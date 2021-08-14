<template>
  <div class="settings-page">
    <div class="subsite_settings__head ui-border--bottom l-island-a l-island-bg l-pt-20 lm-pt-15 l-pb-20 lm-pb-15">
      <div class="subsite_settings__head__title l-fs-29 l-lh-30 lm-fs-22 l-fw-600">Настройки пользователя</div>
    </div>
    <div class="subsite_settings l-island-bg l-pt-15 l-pb-15">
      <div class="subsite_settings__section l-island-a">
        <div class="subsite_settings__section__title">Основные настройки</div>
        <div class="subsite_settings__section__container">
          <main-info/>
          <password v-if="user.have_password"/>
        </div>
      </div>
      <div class="subsite_settings__section l-island-a">
        <div class="subsite_settings__section__title">Связанные аккаунты</div>
        <div class="subsite_settings__section__container">
          <social/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Password from "../../components/User/Settings/Password";
  import {mapGetters} from "vuex";
  import Social from "../../components/User/Settings/Social";
  import AvatarSetting from "../../components/User/Avatar";
  import MainInfo from "../../components/User/Settings/MainInfo";

  export default {
    components: {Social, AvatarSetting, MainInfo, Password},
    middleware: 'auth',

    computed: {
      ...mapGetters({
        user: 'auth/user'
      }),
      tabs() {
        return [
          {
            icon: 'user',
            name: this.$t('profile'),
            route: 'settings.profile'
          },
          {
            icon: 'lock',
            name: this.$t('password'),
            route: 'settings.password'
          }
        ]
      }
    },

    mounted() {

    },
    metaInfo() {
      return {title: 'Настройки пользователя'}
    }
  }
</script>

<style>
  .settings-card .card-body {
    padding: 0;
  }
</style>
