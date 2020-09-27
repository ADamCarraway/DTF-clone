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
                <div @click="subscribe(0)" v-if="data.slug in userSubs"
                     class="v-subscribe-button__unsubscribe v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="fas fa-times icon--ui_close"></i>
                  </div>
                  <span class="v-button__label">Отписаться</span>
                </div>

                <div @click="subscribe(1)" v-if="!(data.slug in userSubs)"
                     class="v-subscribe-button__subscribe v-button v-button--blue v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="fas fa-plus icon--ui_plus"></i>
                  </div>
                  <span class="v-button__label">Подписаться</span>
                </div>

                <div v-if="(data.slug in userSubs) && !this.user.category_notify.includes(data.id)" @click="notify(1)"
                     class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="far fa-bell"></i>
                  </div>
                </div>

                <div v-if="(data.slug in userSubs) && this.user.category_notify.includes(data.id)" @click="notify(0)"
                     class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="fas fa-bell"></i>
                  </div>
                </div>
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
    </div>
  </div>
</template>

<script>
  import EventBus from "../../plugins/event-bus";
  import {mapGetters} from "vuex";
  import axios from "axios";
  import vue from "vue";

  export default {
    name: "category",
    data() {
      return {
        showDescription: false,
        loadingNotify: false,
        loadingSub: false,
        data: []
      }
    },
    computed: mapGetters({
      user: 'auth/user',
      userSubs: 'auth/userSubs',
    }),
    beforeRouteUpdate(to, from, next) {
      this.get(to.params.slug)
      next()
    },
    methods: {
      subscribe(type) {
        this.loadingSub = true;
        if (!type) {
          axios.post('/api/' + this.data.id + '/unsubscribe', this.form).then((res) => {
            this.$store.dispatch('auth/destroyUserSubscription', {slug: this.data.slug})
            this.loadingSub = false;
          })
        }

        if (type) {
          axios.post('/api/' + this.data.id + '/subscribe', this.form).then((res) => {
            this.data['isSub'] = true;
            this.data['isVisible'] = Object.keys(this.userSubs).length < 7;

            this.$store.dispatch('auth/addUserSubscription', {sub: this.data})
            this.loadingSub = false;
          })
        }
      },
      notify(type) {
        this.loadingNotify = true;
        if (type) {
          axios.post('/api/notifications/subscribe/category/' + this.data.id).then((res) => {
            this.user.category_notify.push(this.data.id)
            this.$store.dispatch('auth/updateUser', {user: {'category_notify': this.user.category_notify}})
            this.$Notify.success({
              message: 'Мы уведомим вас о новых записях'
            })
            this.loadingNotify = false;
          })
        }

        if (!type) {
          axios.post('/api/notifications/unsubscribe/category/' + this.data.id).then((res) => {
            const index = this.user.category_notify.indexOf(this.data.id);
            this.user.category_notify.splice(index, 1);

            this.$store.dispatch('auth/updateUser', {user: {'category_notify': this.user.category_notify}})
            this.$Notify.success({
              message: 'Вы отписались от уведомлений о новых записях'
            })
            this.loadingNotify = false;
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
