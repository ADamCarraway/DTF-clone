<template>


  <form @submit.prevent="update" @keydown="form.onKeydown($event)" class="ui_form ui_form--nickname ui_form--2 l-mb-25">
    <fieldset>
      <label for="password">Пароль</label>
      <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control"
             type="password" name="password" id="password">
      <has-error :form="form" field="password"/>
    </fieldset>
    <fieldset>
      <label for="password_confirmation">&nbsp;</label>
      <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
             class="form-control" type="password" name="password_confirmation">
      <has-error :form="form" field="password_confirmation" id="password_confirmation"/>
      <div class="nickname-controls l-inline-block">
        <button class="nickname-controls__button nickname-controls__button--edit t-link-classic">
          Изменить
        </button>
      </div>
    </fieldset>
  </form>
</template>

<script>
  import Form from 'vform'
  import axios from "axios";

  export default {
    name: "Password",

    data: () => ({
      form: new Form({
        password: '',
        password_confirmation: ''
      })
    }),

    methods: {
      async update() {
        await this.form.post('/api/settings/password')

        this.form.reset()
      }
    }
  }
</script>
