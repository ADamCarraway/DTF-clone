<template>
  <div class="v-form-section">
    <label class="v-form-section__label ">
      Роли
    </label>
    <role-modal-user :user="user" v-if="user" />

    <label class="v-form-section__label mt-4">
      Имя и почта
    </label>
    <form @submit.prevent="updateName" class="v-form-section__field d-flex justify-content-between">
      <div class="v-field--text v-field v-field--default w-100" ref="inputElement" data-length="17">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="name" class="v-text-input__input" type="text" maxlength="30" name="name">
          </div>
        </div>
      </div>

      <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
              style="margin-left: 12px">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
      </button>
    </form>

    <form @submit.prevent="updateEmail" class="v-form-section__field d-flex justify-content-between">
      <div class="v-field--text v-field v-field--default w-100">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="email" class="v-text-input__input" maxlength="30" name="email" type="email"
                   id="form_input_email">
          </div>
        </div>
      </div>

      <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
              style="margin-left: 12px">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
      </button>
    </form>

    <label class="v-form-section__label mt-4">
      Пароль
    </label>
    <form @submit.prevent="updatePassword" class="v-form-section__field d-flex justify-content-between">

      <div class="v-field--text v-field v-field--default w-100">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="password" class="v-text-input__input" type="password" name="password" id="password">
          </div>
        </div>
      </div>

      <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
              style="margin-left: 12px">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
      </button>
    </form>

  </div>
</template>

<script>
import axios from "axios";
import RoleModalUser from "./RoleModal";

export default {
  name: 'UpdateForm',
  components: {RoleModalUser},
  data() {
    return {
      name: this.user.name,
      email: this.user.email,
      password: '',
    }
  },
  props: ['user'],
  methods: {
    updateName() {
      axios.post('/api/admin/users/' + this.user.id + '/update', {name: this.name}).then((res) => {
        this.$notify({
          message: 'Имя изменено',
          type: 'success'
        })
      }).catch(error => {
        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
    updateEmail() {
      axios.post('/api/admin/users/' + this.user.id + '/update', {email: this.email}).then((res) => {
        this.$notify({
          message: 'Почта изменена',
          type: 'success'
        })
      }).catch(error => {
        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
    updatePassword() {
      axios.post('/api/admin/users/' + this.user.id + '/update', {password: this.password}).then((res) => {
        this.password = null;
        this.$notify({
          message: 'Пароль изменен',
          type: 'success'
        })
      }).catch(error => {
        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
  }
}
</script>
