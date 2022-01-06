<template>
  <div class="v-form-section">
    <label class="v-form-section__label">
      Имя и почта
    </label>
    <form @submit.prevent="update" class="v-form-section__field d-flex justify-content-between">
      <div class="v-field--text v-field v-field--default w-100" ref="inputElement" data-length="17">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="name" class="v-text-input__input" type="text" maxlength="30" name="name">
          </div>
        </div>
        <!--          <p class="caption ">Смену никнейма можно производить не чаще раза в месяц</p>-->
      </div>

      <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
              style="margin-left: 12px">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
      </button>
    </form>

    <form @submit.prevent="update" class="v-form-section__field d-flex justify-content-between">
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

    <password/>

    <social/>

    <setting-header :data="user"/>
  </div>
</template>

<script>
import axios from 'axios'
import {mapGetters} from 'vuex'
import Password from "./Password";
import Social from "./Social";
import SettingHeader from "./Header";

export default {
  name: "MainInfo",
  components: {SettingHeader, Social, Password},
  scrollToTop: false,

  data() {
    return {
      name: '',
      email: '',
    }
  },

  watch: {
    name: function (val) {
      this.$refs.inputElement.setAttribute('data-length', 30 - val.length);
      this.name = val;
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  created() {
    this.name = this.user['name']
    this.email = this.user['email']
  },

  methods: {
    update() {
      let data = {
        'name': this.name,
        'email': this.email,
      }

      axios.post('/api/settings/profile', data).then((response) => {
        this.$notify({
          message: 'Данные изменены',
          type: 'success'
        });
      })

      this.$store.dispatch('auth/updateUser', {user: data})
    },
  }
}
</script>

<style scoped>

</style>
