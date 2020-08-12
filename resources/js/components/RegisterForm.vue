<template>
  <div class="auth-form__tab auth_tab auth_tab--signup-email">
    <div class="auth-form__back">
      <span class="t-link" @click="show('')">
        <svg class="icon icon--ui_arrow_left" width="7" height="11">
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_arrow_left"></use></svg>
        К авторизации
      </span>
    </div>

    <form @submit.prevent="register" @keydown="form.onKeydown($event)" class="auth-form__content">
      <div v-if="mustVerifyEmail" class="alert alert-success" role="alert">
        {{ $t('verify_email_address') }}
      </div>

      <div class="auth-form__title l-mb-5">Регистрация через почту</div>
      <div class="auth-form__note l-mb-15">или <span class="t-link-inline" @click="show('login-form')">войти в аккаунт</span></div>

      <!-- Name -->
      <div class="row at-row">
        <div class="col-md-24">
          <at-input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" type="text" name="name"
                    placeholder="Имя"></at-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.name">{{ errors.name[0] }}</div>
        </div>
      </div>

      <!-- Email -->
      <div class="row at-row">
        <div class="col-md-24">
          <at-input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" type="email" name="email"
                    placeholder="Почта"></at-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.email">{{ errors.email[0] }}</div>
        </div>
      </div>

      <!-- Password -->
      <div class="row at-row">
        <div class="col-md-24">
          <at-input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" type="password" name="password"
                    placeholder="Пароль"></at-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.password">{{ errors.password[0] }}</div>
        </div>
      </div>

      <!-- Password Confirmation -->
      <div class="row at-row">
        <div class="col-md-24">
          <at-input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" type="password" name="password_confirmation"
                    placeholder="Повторите пароль"></at-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</div>
        </div>
      </div>

      <div class="row at-row">
        <div class="col-md-24 d-flex">
          <!-- Submit Button -->
          <button type="info" class="at-btn at-btn--primary">
            <span class="at-btn__text">Зарегистрироваться</span>
          </button>
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

              this.$store.dispatch('auth/fetchUser')

              this.$router.push({name: 'home'})
            });

            EventBus.$emit('loginModal', false);
          }
        }).catch((er) => {
          this.errors = er.response.data.errors;
        });
      },
      show(name){
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
