<template>
  <div class="auth-form__tab auth_tab auth_tab--signup-email">
    <div class="auth-form__back">
      <span class="t-link" @click="show('')">
       <ion-icon name="chevron-back-outline"></ion-icon>
        Назад
      </span>
    </div>

    <form @submit.prevent="register" @keydown="form.onKeydown($event)" class="auth-form__content">
      <div v-if="mustVerifyEmail" class="alert alert-success" role="alert">
        {{ $t('verify_email_address') }}
      </div>

      <div class="auth-form__title l-mb-5">Регистрация</div>
      <!--      <div class="auth-form__note l-mb-15">или <span class="t-link-inline" @click="show('login-form')">войти в аккаунт</span></div>-->

      <!-- Name -->
      <div class="row">
        <div class="col-md-12">
          <!--          <el-input v-model="form.name" class="ui_form__fieldset" :class="{ 'is-invalid': form.errors.has('name') }" type="text" name="name"-->
          <!--                    placeholder="Имя"></el-input>-->
          <!--          <div class="ui_form__message ui_form__message&#45;&#45;error ui_form__message&#45;&#45;shown" v-if="errors.name">{{ errors.name[0] }}</div>-->

          <div class="v-field__wrapper">
            <label class="v-text-input v-text-input--default">
              <input type="text" name="name"
                     placeholder="Имя и фамилия"
                     v-model="form.name"
                     autocomplete="nope"
                     class="v-text-input__input">
              <!--            <span class="v-text-input__countdown">30</span>-->
            </label>
          </div>
        </div>
      </div>

      <!-- Email -->
      <div class="row ">
        <div class="col-md-12">
          <!--          <el-input v-model="form.email" class="ui_form__fieldset" :class="{ 'is-invalid': form.errors.has('email') }" type="email" name="email"-->
          <!--                    placeholder="Почта"></el-input>-->
          <!--          <div class="ui_form__message ui_form__message&#45;&#45;error ui_form__message&#45;&#45;shown" v-if="errors.email">{{ errors.email[0] }}</div>-->
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
      <div class="row ">
        <div class="col-md-12">
          <!--          <el-input v-model="form.password" class="ui_form__fieldset" :class="{ 'is-invalid': form.errors.has('password') }" type="password" name="password"-->
          <!--                    placeholder="Пароль"></el-input>-->
          <!--          <div class="ui_form__message ui_form__message&#45;&#45;error ui_form__message&#45;&#45;shown" v-if="errors.password">{{ errors.password[0] }}</div>-->
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

      <!-- Password Confirmation -->
      <div class="row ">
        <div class="col-md-12">
          <!--          <el-input v-model="form.password_confirmation" class="ui_form__fieldset" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" type="password" name="password_confirmation"-->
          <!--                    placeholder="Повторите пароль"></el-input>-->
          <!--          <div class="ui_form__message ui_form__message&#45;&#45;error ui_form__message&#45;&#45;shown" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</div>-->
          <div class="v-field__wrapper">

            <label class="v-text-input v-text-input--default">
              <input type="password" name="password_confirmation"
                     placeholder="Повторите пароль"
                     v-model="form.password_confirmation"
                     autocomplete="nope"
                     class="v-text-input__input">
              <!--            <span class="v-text-input__countdown">30</span>-->
            </label>
          </div>
        </div>
      </div>

      <div class="row ">
        <div class="col-md-12">
          <!-- Submit Button -->
          <button class="submit-button form-item v-button v-button--blue v-button--size-default"
                  :class="{'v-button--disabled':!form.name || !form.email || !form.password || !form.password_confirmation}">
            <span class="v-button__label">Зарегистрироваться</span>
          </button>

          <div class="d-flex justify-content-start" style="font-size: 16px">
            <span class="mr-2">Есть аккаунт? </span>
            <div data-gtm="Signup — Login — Click" class="t-link-inline" @click="show('login-form')">
              Войти
            </div>
          </div>
        </div>
      </div>
    </form>

  </div>
</template>

<script>
import Form from "vform";
import EventBus from "../plugins/event-bus";
import axios from "axios";

export default {
  name: "RegisterForm",

  middleware: 'guest',

  metaInfo() {
    return {title: this.$t('register')}
  },

  data: () => ({
    errors: {},
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
    mustVerifyEmail: false
  }),

  methods: {
    register() {
      this.errors = {};

      axios.post('/api/register', this.form).then((res) => {
        if (res.data.status) {
          this.mustVerifyEmail = true;
          this.form.reset()
        } else {
          axios.post('/api/login', this.form).then((res) => {
            this.$store.dispatch('auth/saveToken', {
              token: res.data.token,
              remember: true
            })

            // this.$store.dispatch('auth/fetchUser')

            location.reload()
          });

          EventBus.$emit('loginModal', false);
        }
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

</style>
