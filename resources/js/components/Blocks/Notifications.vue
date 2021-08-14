<template>
  <div class="site-header__item">
    <div class="head-notifies" :class="{'head-notifies--showed': show}">
      <div class="head-notifies__toggler" @click="show = !show">
        <ion-icon src="/icons/notifications-outline.svg"></ion-icon>
        <!--        head-notifies__badge--hidden-->
        <span class="head-notifies__badge"
              :class="{'head-notifies__badge--hidden': !notReading}">{{ notReading }}</span>
      </div>
      <div class="head-notifies__panel l-fs-13" v-if="show">
        <header class="head-notifies__header">
          <span class="head-notifies__header-title t-ff-1-500 lm-hidden">
            <span>Уведомления</span>
          </span>
          <span class="head-notifies__header-link t-link-inline l-hidden">
            <span>Пометить все как прочитанные</span>
          </span>
        </header>
        <div class="head-notifies__items-wrapper"><!---->
          <div class="head-notifies__items" v-if="user">
            <div class="u-notification--border" v-for="item in notifications" :key="item.id">
              <new-comment v-if="item.type === 'App\\Notifications\\AddCommentNotification'" :item="item"/>
              <new-follow v-if="item.type === 'App\\Notifications\\AddFollowNotification'" :item="item"/>
              <like-comment v-if="item.type === 'App\\Notifications\\AddLikeNotification'" :item="item"/>
            </div>
          </div>
          <notification-for-guest v-else/>
          <infinite-loading spinner="waveDots" @distance="1" @infinite="infiniteHandler" v-if="user">
            <div slot="no-results"></div>
            <div slot="no-more"></div>
          </infinite-loading>
          <div class="head-notifies__loader" style="display: none;">
            <div class="v-loader ui_preloader"><span class="ui_preloader__dot"></span> <span
              class="ui_preloader__dot"></span> <span class="ui_preloader__dot"></span></div>
          </div>
        </div>
        <footer class="head-notifies__footer t-ff-1-500">
          <a href="/u/me/updates"
             class="head-notifies__footer-link t-link-inline">
            <span>Все уведомления</span>
          </a>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import EventBus from "../../plugins/event-bus";
  import NotificationForGuest from "./NotificationForGuest";
  import NewComment from "./Notifications/NewComment";
  import axios from "axios";
  import InfiniteLoading from "vue-infinite-loading";
  import NewFollow from "./Notifications/NewFollow";
  import LikeComment from "./Notifications/LikeComment";

  export default {
    name: "Notifications",
    components: {LikeComment, NewFollow, NewComment, NotificationForGuest, InfiniteLoading},
    data() {
      return {
        'show': false,
        'notReading': 0,
        'notifications': [],
        'page': 1,
        'needLoading': true
      }
    },

    computed: mapGetters({
      user: 'auth/user'
    }),

    mounted() {
      if (this.user) {
        Echo.private(`App.Models.User.${this.$store.getters['auth/user']['id']}`).notification(notification => {
          console.log(notification)
          this.notReading += 1;
          this.notifications.unshift({'type': notification.type, 'data': notification.data})
        });
      }
    },
    methods: {
      infiniteHandler($state) {
        axios.get('/api/notification' + '?page=' + this.page)
          .then((data) => {
            if (data.data.data.length) {
              this.page = this.page + 1;
              $.each(data.data.data, (key, value) => {
                this.notifications.push(value);
              });

              $state.loaded();
            } else {
              $state.complete();
            }
          });
      },
    }
  }
</script>

<style scoped>

</style>
