<template>
  <div class="v-form-section user-settings__container">
    <label class="v-form-section__label">
      Обложка
    </label>
    <div class="v-form-section__field justify-content-between">
      <div class="v-field--text v-field v-field--default">
        <div class="v-header-cover_s" :class="{'preloader': !data || preloader}"
             v-if="data.header"
             :style="{ backgroundImage: `url('${data.header}')` }">
          <div class="v-header-cover_s_upd">
            <div class="v-button v-button--default v-button--size-default ui-button--only-icon mr-2"
                 @click="destroy()">
              <div class="v-button__icon">
                <ion-icon name="close-outline" :class="'v-button__icon v-button__icon--new color-red'"></ion-icon>
              </div>
            </div>
            <label for="header-upload"
                   class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
                   v-if="!preloader">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
            </label>
          </div>

        </div>
        <div class="v-form-section__field d-flex justify-content-between" :class="{'preloader': preloader}" v-else>
          <div class="v-field--text v-field v-field--default w-100">
            <div class="v-field__wrapper">
              <div class="v-text-input v-text-input--default">
                <input class="v-text-input__input" value="Оживите обложку профиля приятной анимацией." readonly>
              </div>
            </div>
          </div>

          <label for="header-upload"
                 class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
                 style="margin-left: 12px">
            <span class="v-button__label"><span>Загрузить</span></span>
          </label>
        </div>
      </div>
    </div>
    <input type="file" v-on:change="update" class="" id="header-upload" style="display: none">
  </div>
</template>

<script>
import axios from 'axios'
import {mapGetters} from 'vuex'

export default {
  name: "SettingHeader",
  props: ['data'],
  data() {
    return {
      'preloader': false
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    update(e) {
      this.preloader = true;
      const data = new FormData();
      data.append('header', e.target.files[0]);

      axios.post('/api/settings/header/update', data)
          .then((response) => {
            this.preloader = false;
            this.$notify({
              message: 'Обложка успешно загружена',
              type: 'success'
            });
            this.$store.dispatch('auth/updateUser', {user: {'header': response.data.header}})
          }).catch(error => {
        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
    destroy() {
      this.preloader = true;

      axios.post('/api/settings/header/delete')
          .then((response) => {
            this.preloader = false;

            this.$notify({
              message: 'Обложка успешно удалена',
              type: 'success'
            });
            this.$store.dispatch('auth/updateUser', {user: {'header': null}})
          }).catch(error => {
        this.preloader = false;

        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    }
  }
}
</script>

<style scoped>
.v-header-cover_s {
  height: 280px;
  background-color: #dedede;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: 50% 50%;
  border-radius: 3px;
  position: relative;
  overflow: hidden;
}

.v-header-cover_s_upd {
  color: #000;
  position: absolute;
  bottom: 0;
  right: 0;
  cursor: pointer;
  margin: 5px;
  display: flex;
}
</style>