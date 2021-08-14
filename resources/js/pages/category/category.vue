<template>
  <div v-if="data" class="page--index">
    <div class="l-page l-page--header-content-sidebar l-mb-12">

      <div class="l-page__header">
        <div class="subsite-header"><!---->
          <div class="l-island-bg v-header v-header--with-actions v-header--with-description br-top-0">
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
                  <div class="v-header-description__content" v-if="data.description">
                    <p v-if="!showDescription && data.description.length > 97">
                      {{ data.description.slice(0,97)+' ...'}}
                      <span @click="showDescription = !showDescription" class="v-header-description__more">еще</span>
                    </p>
                    <p v-else>{{ data.description }}</p>
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
                <subscribe :data="data"></subscribe>
                <notification :data="data"></notification>
              </div>
              <ignore :data="data"></ignore>
            </div>

            <div class="v-header__stats">
              <div class="v-header__stat">
                <i class="fas fa-user-friends"></i>
                <span style="font-weight: 500" class="mr-1">{{ data.followers_count }}</span> подписчиков
              </div>
            </div>

            <category-tabs :data="data"></category-tabs>
            <mini-header :data="data"></mini-header>

          </div>
        </div>
      </div>

        <transition name="fade" mode="out-in">
          <router-view :data="data"/>
        </transition>

      <subsite-sidebar v-if="['category', 'category.new'].includes(this.$route.name)" :data="data" :type="'category'"></subsite-sidebar>
      <details-sidebar v-else></details-sidebar>
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
  import SubsiteSidebar from "../../components/User/SubsiteSidebar";
  import CategoryTabs from "../../components/User/CategoryTabs";
  import DetailsSidebar from "../../components/User/Details/Blocks/DetailsSidebar";
  import MiniHeader from "../../components/User/MiniHeader";
  import EventBus from "../../plugins/event-bus";
  import axios from "axios";

  export default {
    name: "category",
    components: {
      MiniHeader,
      DetailsSidebar,
      CategoryTabs,
      SubsiteSidebar, RegulationsBox, UserCategoriesBlock, SubscribersBlock, Ignore, Subscribe, Notification
    },
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
      if (to.params.slug === from.params.slug) return next();

      this.get(to.params.slug)
      EventBus.$emit('changePostsRoute');
      next()
    },
    methods: {
      get(slug) {
        axios.get('/api/subs/'+slug)
          .then((data) => {
            this.data = data.data
          });
      }
    },
    mounted() {
      this.get(this.$route.params.slug)
    },
    metaInfo() {
      return {title: this.data.title}
    }
  }
</script>

<style scoped>

</style>
