<template>
  <div>
    <div class="subsite_head l-island-a l-island-bg l-pv-15">
      <div class="subsite_head__row subsite_head__row--inline l-mr-auto">
        <div class="subsite_head__face l-s-54 lm-s-42 l-mr-15">
          <img class="andropov_image subsite_head__face__avatar andropov_image--bordered andropov_image--zoomable"
               style="background-color: transparent;"
               :src="user.avatar">
          <div class="image_uploader">
            <svg class="icon icon--ui_photo" width="22" height="21">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_photo"></use>
            </svg>
          </div>
        </div>
      </div>

      <div class="subsite_head__row subsite_head__row--inline subsite_head__row--actions">
        <a href="https://dtf.ru/u/10255-sergey-serousov/settings"
           class="subsite_head__settings ui-button ui-button--only-icon ui-button--5 l-ml-15 lm-ml-0 lm-mr-15">
          <i class="icon icon-settings"></i>
        </a>
        <div class="subsite_head__qr l-ml-12 lm-ml-0 lm-mr-12 lm-hidden" air-module="module.authQr" air-click="Auth by qr" data-ios="https://itunes.apple.com/ru/app/id1190484578" data-android="https://play.google.com/store/apps/details?id=ru.cmtt.dtf" title="Авторизоваться через QR-код">
          <svg class="icon icon--ui_qr" width="18" height="18" xmlns="http://www.w3.org/2000/svg">
            <svg viewBox="0 0 18 18" id="ui_qr"><path fill-rule="evenodd" d="M0 18h7.915v-7.964H0V18zm1.636-1.65v-4.896h4.91v4.897h-4.91zm1.637-1.623h1.636v-1.636H3.273v1.636zM13.09 18v-1.637h1.637V18H13.09zm3.273 0v-1.637H18V18h-1.637zm0-7.965H18v4.692h-4.91v-1.636h-1.636V18h-1.46v-7.965h4.733v1.42h1.636v-1.42zM0 7.99V0h7.988v7.99H0zm1.636-1.445h4.91V1.636h-4.91v4.91zM3.273 4.91V3.273h1.636v1.636H3.273zm6.73 3.118V0H18v8.027h-7.996zm1.451-1.482h4.91V1.636h-4.91v4.91zM13.09 4.91V3.273h1.637v1.636H13.09z"></path></svg>
          </svg>
        </div>
      </div>

      <div class="subsite_head__row">
        <p class="subsite_head__name l-to-ellipsis l-fs-30 lm-fs-22 l-lh-34 l-fw-600" style="color: #000">{{ user.name }}</p>
        <div class="subsite_head__karma subsite_head__karma--positive l-fs-13 l-ml-10 l-mt-3">+1</div>
      </div>
      <div class="subsite_head__row">
        <div class="subsite_head__registration_date l-fs-13">
          Зарегистрировался <time class="time">{{ date }}</time>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import moment from 'moment'

  export default {
    middleware: 'auth',
    computed: {
      ...mapGetters({
        user: 'auth/user'
      }),

      date(){
        return moment(this.user.created_at).locale("ru").format('DD MMM YYYY')
      }
    },
    metaInfo() {
      return {title: this.$t('home')}
    }
  }
</script>
