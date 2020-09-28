<template>
  <div class="site-header">
    <div class="site-header__item site-header__item--burger" @click="sidebarChange()">
      <div class="site-header-burger">
        <i class="icon icon-menu icon--ui_burger fs-24"></i>
      </div>
    </div>
    <div class="site-header__item site-header__item--logo">
      <router-link :to="{ name: 'index' }" class="site-header-logo not-active">
        <svg height="50" width="70" class="icon icon--site_logo">
          <use xlink:href="#site_logo">
            <svg viewBox="0 0 70 24" id="site_logo">
              <path
                d="M14.446 0H0v23h14.446c5.014 0 9.091-3.984 9.091-8.883V8.883C23.538 3.984 19.46 0 14.446 0zm3.171 14.117c0 1.708-1.421 3.099-3.17 3.099h-8.53V5.783h8.529c1.748 0 3.17 1.388 3.17 3.1v5.234zm7.591-8.334h8.264v17.169h5.918V5.783h8.264V0H25.208M70 5.783V0H50.889v22.952h5.918V16.19h9.982v-5.78h-9.982V5.783"></path>
            </svg>
          </use>
        </svg>
      </router-link>
    </div>

    <div class="site-header__item site-header__item--spaced site-header__item--centered site-header__item--search">
      <div class="search">
        <!--        //search&#45;&#45;active-->
        <div class="search__field">
          <i class="icon icon-search icon--search fs-16"></i>
          <input type="text" placeholder="Поиск" class="search__input"></div>
      </div>
    </div>

    <div class="site-header__item site-header__item--spaced site-header__item--desktop site-header__item--centered">
      <div class="v-create-button">
        <a href="/writing?to=u" class="v-create-button__main">
          <div class="v-split-button__icon">
            <i class="fas fa-pencil-alt"></i>
          </div>
          <div class="v-create-button__label">
            Новая запись
          </div>
        </a>
      </div>
    </div>


    <div class="site-header__spacer"></div>

    <div class="site-header__item" v-if="user">
      <div class="head-notifies">
        <div class="head-notifies__toggler">
          <i class="far fa-bell fs-24"></i>
          <span class="head-notifies__badge head-notifies__badge--hidden">0</span>
        </div>
      </div>
    </div>

    <div class="site-header__item" v-if="user">
      <div class="site-header-user">
        <at-dropdown trigger="click">
          <div class="site-header-user__avatar" :style="{'background-image': 'url('+user.avatar+')'}"></div>
          <at-dropdown-menu slot="menu">
            <div class="at-dropdown-menu-item__title">Профиль</div>
            <router-link :to="{ name: 'home', params: {id: user.id} }" class="at-dropdown-menu__item item--selected">
              <div class="item__image">
                <img :src="user.avatar">
              </div>
              <span class="item__text">{{ user.name }}</span>
            </router-link>

            <router-link :to="{ name: 'settings' }" class="at-dropdown-menu__item">
              <div class="item__icon">
                <i class="icon icon-settings"></i>
              </div>
              <span class="item__text">Настройки</span>
            </router-link>

            <a href="#" class="at-dropdown-menu__item" @click.prevent="logout" style="color: rgb(233, 42, 64);">
              <div class="item__icon">
                <i class="icon icon-log-out"></i>
              </div>
              Выйти
            </a>
          </at-dropdown-menu>
        </at-dropdown>

      </div>
    </div>

    <div class="site-header__item" v-else @click="loginModal = true">
      <div data-ignore-outside-click="" class="site-header-user">
        <i class="icon icon-user icon--signin fs-24"></i>

        <span class="fs-16">Войти</span>
      </div>
    </div>

    <at-modal v-model="loginModal" :class="'loginBox'">
      <login-box/>
      <div slot="footer">
      </div>
    </at-modal>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import LocaleDropdown from './LocaleDropdown'
  import LoginBox from "./LoginBox";
  import EventBus from "../plugins/event-bus";

  export default {
    components: {
      LoginBox,
      LocaleDropdown
    },

    data: () => ({
      appName: window.config.appName,
      loginModal: false,
      sidebarShow: true
    }),

    computed: mapGetters({
      user: 'auth/user'
    }),

    mounted() {
      let t = this;

      EventBus.$on('loginModal', function (status) {
        t.loginModal = status;
      });
    },

    methods: {
      async logout() {
        // Log out the user.
        await this.$store.dispatch('auth/logout')

        // Redirect to login.
        this.$router.push({name: 'index'})
      },
      sidebarChange() {
        EventBus.$emit('sidebarShow', !this.sidebarShow);
        this.sidebarShow = !this.sidebarShow
      }
    }
  }
</script>

<style scoped>
  .profile-photo {
    width: 2rem;
    height: 2rem;
    margin: -.375rem 0;
  }

  .router-link-exact-active, .item--focused, .item:hover {
    background: #f4f5f6;
    opacity: 1 !important;
  }

  .router-link-exact-active {
    font-weight: bold;
  }

  .router-link-exact-active span, .router-link-exact-active span, .at-dropdown-menu__item:hover {
    background: #f4f5f6;
    opacity: 1 !important;
  }

  .not-active{
    background: #d9f5ff;
  }

</style>
