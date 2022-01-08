<template>
  <div class="auth-form__tab auth_tab auth_tab--signin-email">
    <div class="auth-form__back">
      <span class="t-link" @click="show('')">
        <ion-icon name="chevron-back-outline"></ion-icon>
        Назад
      </span>
    </div>
    <form @submit.prevent="login" @keydown="form.onKeydown($event)" class="auth-form__content">
      <div class="auth-form__title l-mb-5">Вход в аккаунт</div>
      <!--      <div class="auth-form__note l-mb-15">-->
      <!--        или-->
      <!--        <span class="t-link-inline" @click="show('register-form')">зарегистрироваться</span>-->
      <!--      </div>-->
      <!-- Email -->
      <div class="row">
        <div class="col-md-12">
          <!--          <el-input v-model="form.email" class="ui_form__fieldset" :class="{ 'is-invalid': form.errors.has('email') }"-->
          <!--                    type="email" name="email"-->
          <!--                    placeholder="Почта"></el-input>-->
          <!--          <div class="ui_form__message ui_form__message&#45;&#45;error ui_form__message&#45;&#45;shown" v-if="errors.email"-->
          <!--               v-html="errors.email[0]"></div>-->
          <div class="v-field__wrapper">
            <label class="v-text-input v-text-input--default">
              <input type="email" name="email"
                     placeholder="Почта"
                     v-model="form.email"
                     autocomplete="nope"
                     class="v-text-input__input">
              <!--            <span class="v-text-input__countdown">30</span>-->
            </label>
          </div>
        </div>
      </div>

      <!-- Password -->
      <div class="row">
        <div class="col-md-12">
          <!--          <el-input v-model="form.password" class="ui_form__fieldset"-->
          <!--                    :class="{ 'is-invalid': form.errors.has('password') }" type="password"-->
          <!--                    name="password" placeholder="Пароль"></el-input>-->
          <!--          <div class="ui_form__message ui_form__message&#45;&#45;error ui_form__message&#45;&#45;shown" v-if="errors.password">{{-->
          <!--              errors.password[0]-->
          <!--            }}-->
          <!--          </div>-->
          <div class="v-field__wrapper">
            <label class="v-text-input v-text-input--default">
              <input type="password" name="password"
                     placeholder="Пароль"
                     v-model="form.password"
                     autocomplete="nope"
                     class="v-text-input__input">
              <!--            <span class="v-text-input__countdown">30</span>-->
            </label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <button class="submit-button form-item v-button v-button--blue v-button--size-default"
          :class="{'v-button--disabled': !form.email || !form.password}">
            <span class="v-button__label">
              Войти
            </span>
          </button>

          <a class="t-link-inline form-item" @click="show('reset-password-form')">
            <span>Забыли пароль?</span>
          </a>
          <br>
          <br>
          <a class="t-link-inline form-item" @click="show('register-form')">
            <span>Регистрация</span>
          </a>
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
