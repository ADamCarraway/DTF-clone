<template>
  <div class="v-form-section user-settings__container">
    <label class="v-form-section__label">
      Статус онлайн
    </label>
    <div class="v-form-section__field justify-content-between">
      <div class="v-form-section__field d-flex justify-content-between">
        <div class="v-field--text v-field v-field--default w-100">
          <div class="v-field__wrapper">
            <el-select v-model="user.online" @change="change" class="v-text-input__input">
              <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
              </el-option>
            </el-select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {mapGetters} from 'vuex'

export default {
  name: "OnlineStatus",
  data() {
    return {
      'preloader': false,
      options: [
        {
          value: true,
          label: 'Показывать когда я онлайн'
        },
        {
          value: false,
          label: 'Скрыть от всех'
        }
      ]
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    change() {
      let status = this.user.online;

      axios.post('/api/settings/online-status', {'status': this.user.online}).then((response) => {
        this.$notify({
          message: 'Статус обновлен',
          type: 'success'
        });
      }).catch(error => {
        this.user.online = !status;

        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
  }
}
</script>

<style>
.user-settings__container .el-input__inner {
  background-color: transparent!important;
  box-shadow: none!important;
  border: none!important;
  font-size: 16px;
  color: #000;
}
</style>