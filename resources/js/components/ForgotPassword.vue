<template>
  <div class="auth-form__tab auth_tab auth_tab--password">
    <div class="auth-form__back">
      <span class="t-link" @click="back('')">
        <svg class="icon icon--ui_arrow_left" width="7" height="11">
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_arrow_left"></use></svg>
        К авторизации
      </span>
    </div>
    <form @submit.prevent="send" @keydown="form.onKeydown($event)" class="auth-form__content">
      <alert-success :form="form" :message="status"/>

      <!-- Email -->
      <div class="row at-row">
        <div class="col-md-24">
          <el-input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" type="email" name="email"
                    placeholder="Почта"></el-input>
          <div class="ui_form__message ui_form__message--error ui_form__message--shown" v-if="errors.email"
               v-html="errors.email[0]"></div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="row at-row">
        <div class="col-md-24 ml-md-auto">
          <button type="info" class="at-btn at-btn--primary">
            <span class="at-btn__text">Восстановить пароль</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  import Form from 'vform'
  import EventBus from "../plugins/event-bus";
  import axios from "axios";

  export default {
    name: 'ForgotPassword',

    middleware: 'guest',

    metaInfo() {
      return {title: this.$t('reset_password')}
    },

    data: () => ({
      errors: {},
      status: '',
      form: new Form({
        email: ''
      })
    }),

    methods: {
      send() {
        this.errors = {};

        axios.post('/api/password/email', this.form).then((res) => {
          this.status = res.data.status

          this.form.reset()
        }).catch((er) => {
          this.errors = er.response.data.errors
        });
      },
      back(name) {
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
