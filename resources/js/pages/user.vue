<template>
  <div v-if="data">
    <div class="l-page l-page--header-content-sidebar l-mt-12 l-mb-12">

      <div class="l-page__header">
        <div class="subsite-header"><!---->
          <div class="l-island-bg v-header v-header--with-actions v-header--with-description">
            <div v-if="data.header" class="v-header-cover v-header__cover"
                 :style="{ backgroundImage: `url('${data.header}')`, backgroundPosition: `50% 0%` }"></div>

            <div class="v-header__avatar v-header-avatar"
                 :style="{ backgroundImage: `url('${data.avatar}')` }">

            </div>
            <div class="v-header__content">
              <div class="v-header__title">
                <div class="v-header-title">
                  <div class="v-header-title__main">
                    <div class="v-header-title__item v-header-title__name">
                      {{ data.name }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="v-header__actions">
              <div
                class="v-subscribe-button v-subscribe-button--full v-subscribe-button--with-notifications v-subscribe-button--state-active">
                <subscribe v-if="user && data.id !== user.id" :data="data" :type="'users'"> </subscribe>

                <div v-if="(data.id in userUsersSubs) && !this.user.user_notify.includes(data.id)" @click="notify(1)"
                     class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="far fa-bell"></i>
                  </div>
                </div>

                <div v-if="(data.id in userUsersSubs) && this.user.user_notify.includes(data.id)" @click="notify(0)"
                     class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                       aria-hidden="true"></i>
                    <i v-else class="fas fa-bell"></i>
                  </div>
                </div>

                <router-link :to="{name: 'settings'}" v-if="user && user.id == $route.params.id"
                             class="v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i class="fas fa-cog"></i>
                  </div>
                </router-link>
              </div>

              <at-dropdown trigger="click" class="etc_control">
                <span><i class="fas fa-ellipsis-h"></i></span>
                <at-dropdown-menu slot="menu" class="etc_control__list">
                  <div v-if="!this.user.users_ignore.includes(data.id)" @click="toIgnore(1)" class="at-dropdown-menu__item etc_control__item">Игнорировать</div>
                  <div v-else @click="toIgnore(0)" class="at-dropdown-menu__item etc_control__item">Не игнорировать</div>
                </at-dropdown-menu>
              </at-dropdown>
            </div>

            <div class="v-header__stats">
              <div class="v-header__stat">
                <i class="fas fa-egg"></i>
                На проекте с {{ date }}
              </div>
            </div>
            <user-tabs/>
          </div>
        </div>
      </div>

      <div class="l-page__content">
        <transition name="fade" mode="out-in">
          <router-view/>
        </transition>
      </div>

      <div class="l-page__sidebar lm-hidden" style="position: relative;">
        <div data-v-07eabda5="" class="subsite-sidebar" style="width: 300px;">
          <div data-v-07eabda5="" class="l-island-bg l-island-round v-island">
            <div class="v-island__header">
              <span class="v-island__title">
                Подписчики
              </span>
            </div>
            <div data-v-07eabda5="" class="v-island__grayed">
              У вас ещё нет подписчиков
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import {mapGetters} from "vuex";
  import moment from 'moment'
  import UserTabs from "../components/User/UserTabs";
  import axios from "axios";
  import Subscribe from "../components/Buttons/Subscribe";

  export default {
    components: {Subscribe, UserTabs},
    data() {
      return {
        loadingNotify: false,
        loadingSub: false,
        data: {},
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
        userUsersSubs: 'auth/userUsersSubs',
        userCategoriesSubs: 'auth/userCategoriesSubs',
      }),

      date() {
        return moment(this.data.created_at).locale("ru").format('DD MMM YYYY')
      }
    },
    beforeRouteUpdate(to, from, next) {
      this.getData(to.params.id)
      next()
    },
    methods: {
      notify(type) {
        this.loadingNotify = true;
        if (type) {
          axios.post('/api/notifications/subscribe/usersNotify/' + this.data.id).then((res) => {
            this.user.user_notify.push(this.data.id)
            this.$store.dispatch('auth/updateUser', {user: {'user_notify': this.user.user_notify}});
            this.$Notify.success({
              message: 'Мы уведомим вас о новых записях'
            })
            this.loadingNotify = false;
          }).catch(() => {
            this.loadingNotify = false;
          })
        }

        if (!type) {
          axios.post('/api/notifications/unsubscribe/usersNotify/' + this.data.id).then((res) => {
            const index = this.user.user_notify.indexOf(this.data.id);
            this.user.user_notify.splice(index, 1);

            this.$store.dispatch('auth/updateUser', {user: {'user_notify': this.user.user_notify}});
            this.$Notify.success({
              message: 'Вы отписались от уведомлений о новых записях'
            })
            this.loadingNotify = false;
          }).catch(() => {
            this.loadingNotify = false;
          })
        }
      },
      toIgnore(type) {
        if (type) {
          axios.post('/api/ignore/store/usersIgnore/' + this.data.id).then((res) => {
            this.user.users_ignore.push(this.data.id)
            this.$store.dispatch('auth/updateUser', {user: {'users_ignore': this.user.users_ignore}})
            this.$Notify.success({
              message: 'Пользователь добавлен в черный список'
            })
          })
        }

        if (!type) {
          axios.post('/api/ignore/destroy/usersIgnore/' + this.data.id).then((res) => {
            const index = this.user.users_ignore.indexOf(this.data.id);
            this.user.users_ignore.splice(index, 1);

            this.$store.dispatch('auth/updateUser', {user: {'users_ignore': this.user.users_ignore}})
            this.$Notify.success({
              message: 'Пользователь убран из черного списка'
            })
          })
        }
      },
      getData(id) {
        axios.get('/api/u/' + id).then((res) => {
          this.data = res.data;
        })
      }
    },
    created() {
      this.data = this.user && this.user.id === this.$route.params.id ? this.user : this.getData(this.$route.params.id)
    },
    metaInfo() {
      return {title: this.$t('home')}
    }
  }
</script>
