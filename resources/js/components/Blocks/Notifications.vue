<template>
  <div class="site-header__item site-header__item--desktop"
       @focusout="handleFocusOut"
       tabindex="0">
    <div class="head-notifies" :class="{'head-notifies--showed': show}">
      <div class="head-notifies__toggler" @click="show = !show">
        <ion-icon name="notifications-outline"></ion-icon>
        <!--        head-notifies__badge--hidden-->
        <span class="head-notifies__badge"
              :class="{'head-notifies__badge--hidden': !notReading}">{{ notReading }}</span>
      </div>
      <div class="head-notifies__panel l-fs-13" v-if="show">
        <header class="head-notifies__header">
          <span class="head-notifies__header-title t-ff-1-500 lm-hidden">
            <span>Уведомления</span>
          </span>
          <span class="head-notifies__header-link t-link-inline" @click="readAll" v-if="showAllReadBtn">
            <span>Пометить все как прочитанные</span>
          </span>
        </header>
        <div class="head-notifies__items-wrapper"><!---->
          <div class="head-notifies__items" v-if="user">
            <div class="u-notification--border" v-for="item in notifications">
              <new-reply-comment v-if="item.type === 'App\\Notifications\\AddReplyCommentNotification'" :item="item"/>
              <new-comment v-if="item.type === 'App\\Notifications\\AddCommentNotification'" :item="item"/>
              <new-follow v-if="item.type === 'App\\Notifications\\AddFollowNotification'" :item="item"/>
              <like-comment v-if="item.type === 'App\\Notifications\\AddLikeToCommentNotification'" :item="item"/>
              <new-post v-if="item.type === 'App\\Notifications\\AddPostNotification'" :item="item"/>
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
          <div v-if="user && notifications.length === 0">
            <div class="u-notification u-notification--border u-notification--hover text-center">
              Непрочитанных уведомлений нет
            </div>
          </div>
        </div>
        <footer class="head-notifies__footer t-ff-1-500" v-if="user">
          <router-link
              :to="{ name: 'user.notifications', params: {'slug': user.slug} }"
              class="head-notifies__footer-link t-link-inline">
            <span>Все уведомления</span>
          </router-link>
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
import LikePost from "./Notifications/LikePost";
import NewPost from "./Notifications/NewPost";
import NewReplyComment from "./Notifications/NewReplyComment";

export default {
  name: "Notifications",
  components: {
    NewReplyComment,
    NewPost, LikePost, LikeComment, NewFollow, NewComment, NotificationForGuest, InfiniteLoading
  },
  data() {
    return {
      'show': false,
      'notReading': 0,
      'showAllReadBtn': false,
      'notifications': [],
      'page': 1,
      'needLoading': true,
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  mounted() {
    if (this.user) {
      Echo.private(`App.Models.User.${this.$store.getters['auth/user']['id']}`).notification(notification => {
        this.notReading += 1;
        // this.notifications.unshift({'type': notification.type, 'data': notification.data})

        EventBus.$emit('addNotification', {'notification': notification});
      });
    }

  },
  methods: {
    handleFocusOut() {
      this.show = false
    },
    infiniteHandler($state) {
      axios.get('/api/notification' + '?page=' + this.page)
          .then((data) => {
            this.notReading = 0;
            if (data.data.data.length) {
              this.showAllReadBtn = data.data.notRead
              this.page = this.page + 1;
              this.notifications = data.data.data;
              $state.loaded();
            } else {
              $state.complete();
            }
          });

      // const uniqueElementsBy = (arr, fn) =>
      //   arr.reduce((acc, v) => {
      //     if (!acc.some(x => fn(v, x))) acc.push(v);
      //     return acc;
      //   }, []);
      //
      // this.notifications =  uniqueElementsBy(this.notifications,(a, b) => a.type + + a.data.user.id == b.type + + b.data.user.id);
    },

    readAll() {
      axios.post('/api/notification/readAll')
          .then((data) => {
            this.showAllReadBtn = 0;
          });
    }
  }
}
</script>

<style scoped>

</style>
