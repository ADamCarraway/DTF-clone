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
                <div v-if="(data.slug in userCategoriesSubs) && !this.user.category_notify.includes(data.id)" @click="notify(1)"
                     class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="far fa-bell"></i>
                  </div>
                </div>

                <div v-if="(data.slug in userCategoriesSubs) && this.user.category_notify.includes(data.id)" @click="notify(0)"
                     class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="fas fa-bell"></i>
                  </div>
                </div>
              </div>
              <at-dropdown trigger="click" class="etc_control">
                <span><i class="fas fa-ellipsis-h"></i></span>
                <at-dropdown-menu slot="menu" class="etc_control__list">
                  <div v-if="!this.user.categories_ignore.includes(data.id)" @click="toIgnore(1)" class="at-dropdown-menu__item etc_control__item">Игнорировать</div>
                  <div v-else @click="toIgnore(0)" class="at-dropdown-menu__item etc_control__item">Не игнорировать</div>
                </at-dropdown-menu>
              </at-dropdown>
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
    </div>
  </div>
</template>

<script>
  import EventBus from "../../plugins/event-bus";
  import {mapGetters} from "vuex";
  import axios from "axios";
  import vue from "vue";
  import Subscribe from "../../components/Buttons/Subscribe";

  export default {
    name: "category",
    components: {Subscribe},
    data() {
      return {
        showDescription: false,
        loadingNotify: false,
        data: []
      }
    },
    computed: mapGetters({
      user: 'auth/user',
      userCategoriesSubs: 'auth/userCategoriesSubs',
    }),
    beforeRouteUpdate(to, from, next) {
      this.get(to.params.slug)
      next()
    },
    methods: {
      notify(type) {
        this.loadingNotify = true;
        if (type) {
          axios.post('/api/notifications/subscribe/categoriesNotify/' + this.data.id).then((res) => {
            this.user.category_notify.push(this.data.id)
            this.$store.dispatch('auth/updateUser', {user: {'category_notify': this.user.category_notify}})
            this.$Notify.success({
              message: 'Мы уведомим вас о новых записях'
            })
            this.loadingNotify = false;
          }).catch(()=>{
            this.loadingNotify = false;
          })
        }

        if (!type) {
          axios.post('/api/notifications/unsubscribe/categoriesNotify/' + this.data.id).then((res) => {
            const index = this.user.category_notify.indexOf(this.data.id);
            this.user.category_notify.splice(index, 1);

            this.$store.dispatch('auth/updateUser', {user: {'category_notify': this.user.category_notify}})
            this.$Notify.success({
              message: 'Вы отписались от уведомлений о новых записях'
            })
            this.loadingNotify = false;
          }).catch(()=>{
            this.loadingNotify = false;
          })
        }
      },
      toIgnore(type) {
        if (type) {
          axios.post('/api/ignore/store/categoriesIgnore/' + this.data.id).then((res) => {
            this.user.categories_ignore.push(this.data.id)
            this.$store.dispatch('auth/updateUser', {user: {'categories_ignore': this.user.categories_ignore}})
            this.$Notify.success({
              message: 'Подсайт добавлен в черный список'
            })
          })
        }

        if (!type) {
          axios.post('/api/ignore/destroy/categoriesIgnore/' + this.data.id).then((res) => {
            const index = this.user.categories_ignore.indexOf(this.data.id);
            this.user.categories_ignore.splice(index, 1);

            this.$store.dispatch('auth/updateUser', {user: {'categories_ignore': this.user.categories_ignore}})
            this.$Notify.success({
              message: 'Подсайт убран из черного списка'
            })
          })
        }
      },
      get(slug) {
        this.data = window.config.categories[slug]
      }
    },
    created() {
      this.get(this.$route.params.slug)
    }
  }
</script>

<style scoped>

</style>
