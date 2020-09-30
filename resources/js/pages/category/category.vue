<template>
  <div v-if="data">
    <div class="l-page l-page--header-content-sidebar l-mt-12 l-mb-12">

      <div class="l-page__header">
        <div class="subsite-header"><!---->
          <div class="l-island-bg v-header v-header--with-actions v-header--with-description">
            <div v-if="data.header" class="v-header-cover v-header__cover"
                 :style="{ backgroundImage: `url('${data.header}')`, backgroundPosition: `50% 0%` }"></div>

            <div class="v-header__avatar v-header-avatar"
                 :style="{ backgroundImage: `url('${data.icon}')` }">

            </div>
            <div class="v-header__content">
              <div class="v-header__title">
                <div class="v-header-title">
                  <div class="v-header-title__main">
                    <div class="v-header-title__item v-header-title__name">
                      {{ data.title }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="v-header__description">
                <div class="v-header-description">
                  <div class="v-header-description__content">
                    <p v-if="!showDescription && data.description.length > 97">
                      {{ data.description.slice(0,97)+' ...'}}
                      <span @click="showDescription = !showDescription" class="v-header-description__more">еще</span>
                    </p>
                    <p v-if="showDescription">
                      {{ data.description}}
                      <span @click="showDescription = !showDescription" class="v-header-description__more">скрыть</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="v-header__actions">
              <div
                class="v-subscribe-button v-subscribe-button--full v-subscribe-button--with-notifications v-subscribe-button--state-active">
                <subscribe :data="data" :type="'categories'"></subscribe>
                <notification :data="data" :type="'categories'"></notification>
              </div>
              <at-dropdown trigger="click" class="etc_control">
                <span><i class="fas fa-ellipsis-h"></i></span>
                <at-dropdown-menu slot="menu" class="etc_control__list">
                  <ignore :data="data" :type="'categories'"></ignore>
                </at-dropdown-menu>
              </at-dropdown>
            </div>

            <div class="v-header__stats">
              <div class="v-header__stat">
                <i class="fas fa-users"></i>
                <span style="font-weight: 500">{{ data.users_count }}</span>  подписчиков
              </div>
            </div>

            <div class="v-header__tabs">
              <div class="v-tabs">
                <div class="v-tabs__scroll">
                  <div class="v-tabs__content"><a href="https://dtf.ru/games/entries" class="v-tab v-tab--active"><span
                    class="v-tab__label">
            Статьи

            <span class="v-tab__counter">
              16 038
            </span></span></a><a href="https://dtf.ru/games/comments" class="v-tab"><span class="v-tab__label">
            Комментарии

            <span class="v-tab__counter">
              10
            </span></span></a><a href="https://dtf.ru/games/details" class="v-tab"><span class="v-tab__label">
            Подробнее

                    <!----></span></a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="l-page__content">
        Posts
      </div>

      <div class="l-page__sidebar lm-hidden" style="position: relative;">
        <div data-v-07eabda5="" class="subsite-sidebar" style="width: 300px;">
          <subscribers-block :users="data.users" :count="data.users_count"></subscribers-block>
          <regulations-box v-if="data.regulations !== null" :data="data.regulations"></regulations-box>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import Subscribe from "../../components/Buttons/Subscribe";
  import Notification from "../../components/Buttons/Notification";
  import Ignore from "../../components/Buttons/Ignore";
  import SubscribersBlock from "../../components/Blocks/SubscribersBlock";
  import UserCategoriesBlock from "../../components/Blocks/UserCategoriesBlock";
  import RegulationsBox from "../../components/Blocks/RegulationsBox";

  export default {
    name: "category",
    components: {RegulationsBox, UserCategoriesBlock, SubscribersBlock, Ignore, Subscribe, Notification},
    data() {
      return {
        showDescription: false,
        data: [],
      }
    },
    computed: mapGetters({
      user: 'auth/user',
    }),
    beforeRouteUpdate(to, from, next) {
      this.get(to.params.slug)
      next()
    },
    methods: {
      get(slug) {
        this.data = window.config.categories[slug]
        console.log(window.config.categories[slug])
      }
    },
    created() {
      this.get(this.$route.params.slug)
    }
  }
</script>

<style scoped>

</style>
