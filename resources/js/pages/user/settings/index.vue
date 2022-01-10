<template>
  <div class="settings-page page--index">
    <div class="user-settings l-page l-page--content-sidebar l-mt-20 l-mb-20">
      <div class="l-page__content">
        <div class="user-settings__content l-island-bg l-island-round v-island">
          <div class="l-page__content">
            <a href="https://dtf.ru/u/24211-sergey-serousov" class="settings-header user-settings__header">
              <ion-icon name="chevron-back-outline" class="settings-header__icon icon icon--v_arrow_left"></ion-icon>
              <span class="settings-header__text">
                <router-link :to="{ name: 'user', params: {slug: user.slug} }">{{ user.name }}</router-link>
              </span>
            </a>
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
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
    tabs() {
      return [
        {
          name: 'Основные',
          route: 'user.settings.main',
          active: ['user.settings.main'],
          icon: 'settings-outline'
        },
        {
          name: 'Уведомления',
          route: 'user.settings.notifications',
          active: ['user.settings.notifications'],
          icon: 'notifications-outline'
        },
        {
          name: 'Черный список',
          route: 'user.settings.blocklist',
          active: ['user.settings.blocklist'],
          icon: 'close-circle-outline'
        },
      ]
    }
  },
}
</script>

<style scoped>

</style>
