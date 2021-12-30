<template>
  <div class="v-form-section">
    <label class="v-form-section__label">
      Уведомления на сайте
    </label>

    <div class="v-form-section__field">
      <form>
        <el-checkbox class="item" v-for="item in notifications" v-model="form[item.notification]"
                     :key="item.notification">
          <span class="notify-text">{{ names[item.notification] }}</span>
        </el-checkbox>
      </form>
    </div>

    <div class="scroll-footer scroll-footer--has-divider settings-footer l-island-bg">
      <button class="user-plus__save-button v-button v-button--blue v-button--size-default" @click="update()">
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
    return {
      notifications: {},
      names: {
        'App\\Notifications\\AddCommentNotification': 'Новые комментарии к постам',
        'App\\Notifications\\AddFollowNotification': 'Новые подписчики',
        'App\\Notifications\\AddLikeToCommentNotification': 'Оценки комментариев',
        'App\\Notifications\\AddLikeToPostNotification': 'Оценки записей',
        'App\\Notifications\\AddPostNotification': 'Новые записи',
      },
      form: {
        'App\\Notifications\\AddCommentNotification': true,
        'App\\Notifications\\AddFollowNotification': true,
        'App\\Notifications\\AddLikeToCommentNotification': true,
        'App\\Notifications\\AddLikeToPostNotification': true,
        'App\\Notifications\\AddPostNotification': true,
      }
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    update() {
      axios.post('/api/settings/notification', this.form).then((response) => {
        this.$notify({
          message: 'Настройки успешно сохранены',
          type: 'success'
        });
      })
    },
  },
  created() {
    axios.get('/api/settings/notification').then((response) => {
      this.notifications = response.data
      this.notifications.forEach((value, index, array) => {
        this.form[value.notification] = Boolean(value.status);
      });
    })
  }
}
</script>

<style scoped>
/*.el-checkbox__inner{*/
/*  width: 18px!important;*/
/*  height: 18px!important;*/
/*}*/
.item {
  display: block;
  margin-top: 8px;
  padding: 4px 0 4px 0px;
  font-size: 16px;
  color: #000;
  font-weight: 100;
}
</style>
