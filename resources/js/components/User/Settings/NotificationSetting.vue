<template>
  <div class="v-form-section">
    <label class="v-form-section__label">
      Уведомления на сайте
    </label>

    <div class="v-form-section__field">
      <el-checkbox class="item"><span class="notify-text">Ответы на мои комментарии</span></el-checkbox>
      <el-checkbox class="item"><span class="notify-text">Упоминания в комментариях к постам</span></el-checkbox>
      <el-checkbox class="item"><span class="notify-text">Оценки записей и комментариев</span></el-checkbox>
      <el-checkbox class="item"><span class="notify-text">Новые комментарии к постам</span></el-checkbox>
      <el-checkbox class="item"><span class="notify-text">Новые подписчики</span></el-checkbox>
    </div>

    <div class="scroll-footer scroll-footer--has-divider settings-footer l-island-bg">
      <button class="user-plus__save-button v-button v-button--blue v-button--size-default">
        <span class="v-button__label">
          <span>Сохранить</span>
        </span>
      </button>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import {mapGetters} from 'vuex'

export default {
  name: "NotificationSetting",
  scrollToTop: true,

  data() {
    return {}
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    update() {
      let data = {
        // 'name': this.name,
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
/*.el-checkbox__inner{*/
/*  width: 18px!important;*/
/*  height: 18px!important;*/
/*}*/
.item{
  display: block;
  margin-top: 8px;
  padding: 4px 0 4px 0px;
  font-size: 16px;
  color: #000;
  font-weight: 100;
}
</style>
