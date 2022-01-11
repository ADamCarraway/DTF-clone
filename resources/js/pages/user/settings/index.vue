<template>
  <div class="settings-page page--index">
    <div class="user-settings l-page l-page--content-sidebar l-mt-20 l-mb-20">
      <div class="l-page__content">
        <div class="user-settings__content l-island-bg l-island-round v-island">
          <div class="l-page__content">
            <div class="mobile-navbar user-settings__mobile-navbar">
              <router-link :to="{ name: 'user.settings'}" class="mobile-navbar__back" v-if="!showMobileTab">
                <ion-icon name="arrow-back-outline"></ion-icon>
              </router-link>
              <div class="mobile-navbar__back" v-else></div>
              <div class="mobile-navbar__name">
                {{ user.name }}
              </div>
              <router-link :to="{ name: 'user', params: {slug: user.slug} }" class="mobile-navbar__close">
                <ion-icon name="close-outline"></ion-icon>
              </router-link>
            </div>
            <router-link :to="{ name: 'user', params: {slug: user.slug} }"
                         class="settings-header user-settings__header">
              <ion-icon name="chevron-back-outline" class="settings-header__icon icon icon--v_arrow_left"></ion-icon>
              <span class="settings-header__text">
                {{ user.name }}
              </span>
            </router-link>
            <div class="sidebar-navigation__mobile l-island-bg v-island" v-if="showMobileTab">
              <div class="user-settings__container">
                <div @click="showMobileTab = !showMobileTab">
                  <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route }" class="mobile-tab">
                <span class="mobile-tab__icon">
                  <ion-icon :name="tab.icon"></ion-icon>
                </span>
                    <div class="mobile-tab__content">
                      <span class="mobile-tab__label">{{ tab.name }}</span>
                      <span class="mobile-tab__caption">{{ tab.desc }}</span>
                    </div>
                    <ion-icon name="chevron-forward-outline"></ion-icon>
                  </router-link>

                </div>
              </div>
            </div>
            <div class="user-settings__container">
              <transition name="fade" mode="out-in">
                <router-view/>
              </transition>
            </div>
          </div>
        </div>
      </div>

      <div class="user-settings__sidebar l-page__sidebar"
           style="position: relative; display: flex; flex-direction: column; justify-content: flex-start;">
        <div class="sticky-sidebar user-settings__sticky-container"
             style="margin-top: 0px; will-change: position, margin-top; position: sticky; top: 80px; bottom: auto;">
          <div class="sidebar-navigation user-settings__navigation">
            <div class="l-island-bg l-island-round v-island sidebar-navigation__desktop">
              <div class="v-island__header">
                <span class="v-island__title">Настройки</span>
              </div>

              <div class="v-list-tabs">
                <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route }"
                             class="v-list-tab"
                             :class="{'v-list-tab--active': tab.active.includes($route.name)}">

                  <div class=" v-list-tab">
                <span class="v-list-tab__icon">
                        <ion-icon :name="tab.icon"></ion-icon>
                      </span>
                    <div class="v-list-tab__label">
                      <span class="v-list-tab__label-text">{{ tab.name }}</span>
                    </div>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<!--                               :class="{'v-tab&#45;&#45;active': tab.active.includes($route.name)}"-->

<script>
import {mapGetters} from "vuex";

export default {
  name: "index",
  middleware: 'private',
  data() {
    return {}
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
    showMobileTab() {
      return this.$route.name === 'user.settings';
    },
    watch: {
      showMobileTab: function (val) {
        this.showMobileTab = this.$route.name === 'user.settings' ? true : val
      },
    },
    tabs() {
      return [
        {
          name: 'Основные',
          route: 'user.settings.main',
          active: ['user.settings.main'],
          icon: 'settings-outline',
          desc: 'Способы входа и приватность'
        },
        {
          name: 'Уведомления',
          route: 'user.settings.notifications',
          active: ['user.settings.notifications'],
          icon: 'notifications-outline',
          desc: 'Уведомления на сайте и почта'
        },
        {
          name: 'Черный список',
          route: 'user.settings.blocklist',
          active: ['user.settings.blocklist'],
          icon: 'close-circle-outline',
          desc: 'Фильтр по словам и пользователям'
        },
      ]
    }
  },
}
</script>

<style scoped>

</style>
