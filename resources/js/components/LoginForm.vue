<template>
  <div class="auth-form__tab auth_tab auth_tab--signin-email">
    <div class="auth-form__back">
      <span class="t-link" @click="show('')">
        <svg class="icon icon--ui_arrow_left" width="7" height="11">
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_arrow_left"></use></svg>
        К авторизации
      </span>
    </div>
    <form @submit.prevent="login" @keydown="form.onKeydown($event)" class="auth-form__content">
      <div class="auth-form__title l-mb-5">Войти через почту</div>
      <div class="auth-form__note l-mb-15">или <span class="t-link-inline" @click="show('register-form')">зарегистрироваться</span>

      </div>
      <!-- Email -->
      <div class="row at-row">
        <div class="col-md-24">
          <at-input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" type="email" name="email"
                    placeholder="Почта"></at-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.email" v-html="errors.email[0]"></div>
        </div>
      </div>

      <!-- Password -->
      <div class="row at-row">
        <div class="col-md-24">
          <at-input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" type="password"
                    name="password" placeholder="Пароль"></at-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.password">{{ errors.password[0] }}</div>
        </div>
      </div>

      <!-- Remember Me -->
      <div class="row at-row">
        <div class="col-md-24 d-flex ">

          <a @click="show('reset-password-form')" class="small ml-auto my-auto">
            Я забыл пароль
          </a>
        </div>
      </div>

      <div class="row at-row">
        <div class="col-md-24">
          <!-- Submit Button -->
          <button type="info" class="at-btn at-btn--primary">
            <span class="at-btn__text">Войти</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  import SocialAuthBox from "./SocialAuthBox";
  import Form from "vform";
  import EventBus from "../plugins/event-bus";
  import axios from "axios"

  export default {
    name: "LoginForm",
    components: {SocialAuthBox},

    metaInfo() {
      return {title: this.$t('login')}
    },

    data: () => ({
      errors: {},
      form: new Form({
        email: '',
        password: ''
      }),
      remember: false
    }),

    methods: {
      login() {
        this.errors = {};

        axios.post('/api/login', this.form).then((res) => {
          EventBus.$emit('loginModal', false);

          this.$store.dispatch('auth/saveToken', {
            token: res.data.token,
            remember: this.remember
          })

          // this.$store.dispatch('auth/fetchUser')

          location.reload()

          // this.$router.push({name: 'home', params: {id: res.data.id}})
        }).catch((er) => {
          this.errors = er.response.data.errors;
        });
      },
      show(name) {
        EventBus.$emit('show', name);
      },
    }
  }
</script>

<style scoped>
  .at-row {
    margin-bottom: 12px;
  }
</style>
