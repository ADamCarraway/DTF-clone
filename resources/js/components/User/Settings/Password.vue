<template>
  <div class="v-form-section user-settings__container">
    <label class="v-form-section__label">
      Пароль
    </label>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)" class="v-form-section__field d-flex justify-content-between">

      <div class="v-field--text v-field v-field--default">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="form.password" class="v-text-input__input"   type="password" name="password" id="password">
          </div>
        </div>
        <has-error :form="form" field="password"/>
      </div>
      <div class="v-field--text v-field v-field--default">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="form.password_confirmation" class="v-text-input__input"   type="password" name="password_confirmation">
          </div>
        </div>
        <has-error :form="form" field="password_confirmation"/>
      </div>

      <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default" style="">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
      </button>
    </form>
  </div>
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
