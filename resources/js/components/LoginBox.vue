<template>
  <div class="auth-form">
    <div class="auth-form__art"
         style="background-image: url(https://leonardo.osnova.io/356f8b87-e803-86ab-2875-f11915f78a7e/-/scale_crop/600x1154/center/); color: #000000">
      <img src="/logo.png" class="site_logo">
<!--      <svg class="icon icon&#45;&#45;site_logo" width="70" height="23">-->
<!--        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#site_logo"></use>-->
<!--      </svg>-->
    </div>
    <button type="button" aria-label="Close" class="el-dialog__headerbtn" @click="modalHide()"><i class="el-dialog__close el-icon el-icon-close"></i></button>
    <div class="auth-form__main">
      <login-form v-if="show === 'login-form'"/>

      <register-form v-if="show === 'register-form'"/>

      <forgot-password  v-if="show === 'reset-password-form'"/>

      <social-auth-box v-if="showPanel"/>

      <div class="auth-form__note">
        Авторизуясь, вы соглашаетесь с <a class="t-link-classic" href="/terms" data-no-ajax="">правилами пользования
        сайтом</a>
        и даете <a class="t-link-classic" href="/agreement" data-no-ajax="">согласие на обработку персональных
        данных</a>.
      </div>
    </div>
  </div>
</template>

<script>

  import SocialAuthBox from "./SocialAuthBox";
  import LoginForm from "./LoginForm";
  import RegisterForm from "./RegisterForm";
  import ForgotPassword from "./ForgotPassword";
  import EventBus from "../plugins/event-bus";

  export default {
    name: 'LoginBox',

    components: {
      ForgotPassword,
      RegisterForm,
      LoginForm,
      SocialAuthBox,
    },

    data() {
      return {
        show: '',
        showPanel: true
      }
    },

    mounted() {
      let t = this;

      EventBus.$on('show', function (name) {
        t.show = name;
        if (t.show) {
          t.showPanel = false;
        } else {
          t.showPanel = true;
        }
      });
    },
    methods:{
      modalHide(){
        EventBus.$emit('loginModal', false);
      }
    }
  }
</script>

<style scoped>
  .el-dialog__headerbtn{
    top: 0;
    right: 0;
    padding: 9px 9px;
    font-size: 19px;
    color: #595959;
  }
</style>
