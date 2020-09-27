<template>
  <div v-if="data">
    <div class="subsite__cover subsite__cover--image" v-if="data.header">
      <div class="subsite__cover__crop " style="background-color: #dcf4fc">
        <img class="subsite__cover__media" style="top: 0%"
             :src="data.header">
      </div>
    </div>

    <div class="subsite_head l-island-a l-island-bg l-pv-15">
      <div class="subsite_head__row subsite_head__row--inline l-mr-auto">
        <div class="subsite_head__face l-s-54 lm-s-42 l-mr-15">

          <img class="andropov_image subsite_head__face__avatar andropov_image--bordered andropov_image--zoomable"
               style="background-color: transparent;"
               :src="data.icon">
        </div>
      </div>
      <div class="subsite_head__row subsite_head__row--inline subsite_head__row--actions">

        <div
          class="subsite_subscribe_button subsite_subscribe_button--size-default subsite_subscribe_button--state-active subsite_subscribe_button--notifications-disabled subsite_subscribe_button--with-notifications l-ml-12 l-ml-12 lm-ml-0 lm-mr-12">
          <div class="subsite_subscribe_button__main">

            <div @click="subscribe(0)" v-if="data.slug in userSubs"
                 class="ui-button ui-button--unsubscribe ui-button--5 ui-button--wide">
              <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status" aria-hidden="true"></i>
              <i v-else class="fas fa-times icon--ui_close mr-10"></i>
              <span>Отписаться</span>
            </div>

            <div @click="subscribe(1)" v-if="!(data.slug in userSubs)"
                 class="ui-button ui-button--subscribe ui-button--1 ui-button--wide">
              <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status" aria-hidden="true"></i>
              <i v-else class="fas fa-plus icon--ui_plus mr-10"></i>
              <span >Подписаться</span>
            </div>
          </div>

          <div v-if="(data.slug in userSubs) && !this.user.category_notify.includes(data.id)" @click="notify(1)"
               class="ui-button ui-button--only-icon ui-button--5 ui-button--notifications l-ml-12 subsite_subscribe_button__notifications">
            <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
            <i v-else class="far fa-bell"></i>
          </div>

          <div v-if="(data.slug in userSubs) && this.user.category_notify.includes(data.id)" @click="notify(0)"
               class="ui-button ui-button--only-icon ui-button--5 ui-button--notifications l-ml-12 subsite_subscribe_button__notifications">
            <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>
            <i v-else class="fas fa-bell"></i>
          </div>

        </div>

      </div>

      <div class="subsite_head__row">

        <p class="subsite_head__name l-to-ellipsis l-fs-30 lm-fs-22 l-lh-34 l-fw-600">{{ data.title}}</p>


        <span class="approved_user" title="Официальная страница">
    <svg class="icon icon--ui_verified" width="14" height="14" xmlns="http://www.w3.org/2000/svg"><use
      xlink:href="#ui_verified"></use></svg></span>


      </div>
      {{user.category_notify }}

      <div class="subsite_head__row">

        <div class="subsite_head__description l-fs-15 l-lh-21 lm-fs-13 lm-lh-18">
          <div class="rolled-up-text" data-one-name="rolled-up-text_59f478dd34">
            <!--            <div class="rolled-up-text__short"><p>Профессиональное издание о развлечениях. Новости и аналитика об играх,-->
            <!--              а также актуальная информация из мира кино и…</p></div>-->
            <div class="rolled-up-text__full">
              <p>
                {{ data.description }}
              </p>
            </div>
            <span class="rolled-up-text__label" data-one-click="add_mod:rolled-up-text_59f478dd34:open">подробнее</span>
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
