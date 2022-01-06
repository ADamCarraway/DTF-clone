<template>
  <div class="v-form-section user-settings__container">
    <label class="v-form-section__label">
      Записи в блоге
    </label>
    <div class="v-form-section__field justify-content-between">
      <div class="v-form-section__field d-flex justify-content-between">
        <div class="v-field--text v-field v-field--default w-100">
          <div class="v-field__wrapper">
            <el-select v-model="user.show_posts" @change="change" class="v-text-input__input">
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
  name: "ShowPosts",
  data() {
    return {
      'preloader': false,
      options: [
        {
          value: true,
          label: 'Показывать всем'
        },
        {
          value: false,
          label: 'Показывать только подписчикам'
        }
      ]
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    change() {
      let status = this.user.show_posts;

      axios.post('/api/settings/show-posts', {'status': status}).then((response) => {
        this.user.show_posts = status
        this.$notify({
          message: 'Показ записей обновлен',
          type: 'success'
        });
      }).catch(error => {
        this.user.show_posts = !status;

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