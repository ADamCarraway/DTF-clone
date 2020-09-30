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
                <notification v-if="(data.id in userUsersSubs)" :data="data" :type="'users'"></notification>

                <router-link :to="{name: 'settings'}" v-if="user && user.id == $route.params.id"
                             class="v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i class="fas fa-cog"></i>
                  </div>
                </router-link>
              </div>

              <at-dropdown v-if="user" trigger="click" class="etc_control">
                <span><i class="fas fa-ellipsis-h"></i></span>
                <at-dropdown-menu slot="menu" class="etc_control__list">
                  <ignore :data="data" :type="'users'"></ignore>
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
          <subscribers-block :users="data.subscribers"></subscribers-block>
          <user-categories-block :categories="data.categories"></user-categories-block>
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
  import Notification from "../components/Buttons/Notification";
  import Ignore from "../components/Buttons/Ignore";
  import SubscribersBlock from "../components/Blocks/SubscribersBlock";
  import UserCategoriesBlock from "../components/Blocks/UserCategoriesBlock";

  export default {
    components: {UserCategoriesBlock, SubscribersBlock, Ignore, Subscribe, UserTabs, Notification},
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
