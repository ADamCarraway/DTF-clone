<template>
  <div class="notifications-page">
    <div class="l-island-bg  l-island-round">
      <div class="v-island__header v-island mb-0">
        <div class="v-island__header-slot">
          <div class="notifications-header">
            <div class="notifications-header__title">Уведомления</div>
            <div class="notifications-header__mark-as-read t-link-inline" @click="readAll" v-if="showAllReadBtn">
              Пометить все как прочитанные
            </div>
          </div>
        </div>
      </div>
      <div class="u-notifications">
        <div class="u-notification--border" v-for="item in data">
          <new-reply-comment v-if="item.type === 'App\\Notifications\\AddReplyCommentNotification'" :item="item"/>
          <new-comment v-if="item.type === 'App\\Notifications\\AddCommentNotification'" :item="item"/>
          <new-follow v-if="item.type === 'App\\Notifications\\AddFollowNotification'" :item="item"/>
          <like-comment v-if="item.type === 'App\\Notifications\\AddLikeToCommentNotification'" :item="item"/>
          <new-post v-if="item.type === 'App\\Notifications\\AddPostNotification'" :item="item"/>
        </div>
      </div>
      <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
        <div slot="no-results">
          <div class="l-island-bg v-island">
            <div class="v-island__dummy">
              Уведомлений нет
            </div>
          </div>
        </div>
        <div slot="no-more"></div>
      </infinite-loading>
    </div>
  </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import axios from "axios";
import NewPost from "../../components/Blocks/Notifications/NewPost";
import LikePost from "../../components/Blocks/Notifications/LikePost";
import LikeComment from "../../components/Blocks/Notifications/LikeComment";
import NewFollow from "../../components/Blocks/Notifications/NewFollow";
import NewComment from "../../components/Blocks/Notifications/NewComment";
import NotificationForGuest from "../../components/Blocks/NotificationForGuest";
import NewReplyComment from "../../components/Blocks/Notifications/NewReplyComment";

export default {
  name: "notification",
  middleware: 'private',
  components: {
    NewReplyComment,
    NewPost, LikePost, LikeComment, NewFollow, NewComment, NotificationForGuest, InfiniteLoading
  },
  data() {
    return {
      showAllReadBtn: false,
      data: [],
      page: 1,
      infiniteId: +new Date(),
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/notification?page=' + this.page)
          .then((data) => {
            if (data.data.data.length) {
              this.showAllReadBtn = data.data.notRead
              this.page = this.page + 1;
              $.each(data.data.data, (key, value) => {
                this.data.push(value);
              });

              $state.loaded();
            } else {
              $state.complete();
            }
          });
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
