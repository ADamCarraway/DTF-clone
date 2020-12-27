<template>
  <div>
    <div class="l-page l-page--header-content-sidebar l-mt-12 l-mb-12">

      <div class="l-page__header">
        <div class="subsite-header"><!---->
          <div class="l-island-bg v-header v-header--with-actions v-header--with-description">
            <div v-if="data.header" class="v-header-cover v-header__cover"
                 :style="{ backgroundImage: `url('${data.header}')`, backgroundPosition: `50% 0%` }"></div>

            <div :class="{'preloader': !data.avatar}" class="v-header__avatar v-header-avatar"
                 :style="{ backgroundImage: `url('${data.avatar}')` }">
            </div>

            <div class="v-header__content">
              <div class="v-header__title">
                <div class="v-header-title">
                  <div class="v-header-title__main">
                    <div :class="{'preloader preloader-name': !data.name}"  class="v-header-title__item v-header-title__name">
                      {{ data.name }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="v-header__actions">
              <div v-if="!data.id" class="preloader preloader-actions"></div>
              <div v-else
                   class="v-subscribe-button v-subscribe-button--full v-subscribe-button--with-notifications v-subscribe-button--state-active">
                <subscribe v-if="user && data.id !== user.id" :data="data" :type="data.type"></subscribe>
                <notification :data="data" :type="'users'"></notification>

                <router-link :to="{name: 'user.settings', params: {slug: data.slug}}"
                             v-if="data.slug && user && user.slug == $route.params.slug"
                             class="v-button v-button--default v-button--size-default">
                  <div class="v-button__icon">
                    <i class="fas fa-cog"></i>
                  </div>
                </router-link>
              </div>

              <at-dropdown v-if="user && user.slug !== $route.params.slug" trigger="click" class="etc_control">
                <span><i class="fas fa-ellipsis-h"></i></span>
                <at-dropdown-menu slot="menu" class="etc_control__list">
                  <ignore :data="data" :type="'users'"></ignore>
                </at-dropdown-menu>
              </at-dropdown>
            </div>

            <div class="v-header__stats">
              <div :class="{'preloader preloader-stat': !data.created_at}" class="v-header__stat">
                <i class="fas fa-egg"></i>
                На проекте с {{ date }}
              </div>
            </div>
            <user-tabs/>
            <mini-header :data="data"></mini-header>
          </div>
        </div>
      </div>

      <div class="l-page__content">
        <transition name="fade" mode="out-in">
          <router-view :data="data"/>
        </transition>
      </div>

      <subsite-sidebar v-if="['user', 'user.new', 'user.comments'].includes(this.$route.name)" :data="data"></subsite-sidebar>
      <user-details-sidebar v-else></user-details-sidebar>

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
  import SubsiteSidebar from "../components/User/SubsiteSidebar";
  import DetailsSidebar from "../components/User/Details/Blocks/DetailsSidebar";
  import UserDetailsSidebar from "../components/User/Details/Blocks/UserDetailsSidebar";
  import MiniHeader from "../components/User/MiniHeader";
  import EventBus from "../plugins/event-bus";

  export default {
    components: {
      MiniHeader,
      UserDetailsSidebar,
      SubsiteSidebar, UserCategoriesBlock, SubscribersBlock, Ignore, Subscribe, UserTabs, Notification
    },
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
      }),

      date() {
        return moment(this.data.created_at).locale("ru").format('DD MMM YYYY')
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.getData(to.params.slug);
      });
    },
    beforeRouteUpdate(to, from, next) {
      this.data = {};
      this.getData(to.params.slug);
      EventBus.$emit('changePostsRoute');
      next()
    },
    methods: {
      getData(slug) {
        if (this.user && this.user.slug === slug) {
          this.data = this.user
        } else {
          axios.get('/api/u/' + slug).then((res) => {
            this.data = res.data;
          })
        }
      }
    },
    metaInfo() {
      return {title: this.data.name + ' - Блог'}
    }
  }
</script>

<style scoped>
  .ui-sorting {
    margin: 0;
  }
</style>
