<template>
  <div class="layout__right-column layout__sticky" :class="[{'layout__right-column-hide' : !show}]" v-if="user">
    <div class="live l-h-full" :class="[{'live-hide' : !show}]">
      <div class="live__caption" :class="[{'live__caption_border-hide' : !show}]" @click="show=!show">

        <p class="live__title" :class="[{'live__title-hide' : !show}]">
          Комментарии
        </p>

        <div class="live__toggle text-dark">
          <i class="el-icon-arrow-right" v-if="show"></i>
          <i class="el-icon-arrow-left" v-else></i>
        </div>

      </div>
      <div class="live__content" v-if="show">
        <div class="live__scrollable_parent">
          <div class="live__scrollable">
            <div v-for="comment in comments" :key="comment.id" class="live__item live__item--comment">
              <div v-if="comment.type === 'comment'">
                <div class="live__item__header">
                  <router-link :to="{ name: 'user', params: {slug: comment.user.slug} }" class="live__item__user">
                    <img class="andropov_image live__item__user__image" :src="comment.user.avatar"
                         style="background-color: transparent;">
                    <p class="live__item__user__name"><span>{{ comment.user.name }}</span></p>
                  </router-link>
                  <div class="live__item__date" style="cursor: default">
                    {{ comment.date_minute }}
                  </div>
                </div>
                <router-link
                  class="live__item__content "
                  :to="{ name: comment.post.category ? 'post' :'user.post', params: {postSlug: comment.post.slug, slug: comment.post.category ? comment.post.category.slug : comment.user.slug}}"
                  :title="comment.post.title">
                  <div class="live__item__text">{{ comment.comment }}</div>
                </router-link>
                <router-link
                  class="live__item__title "
                  :to="{ name: comment.post.category ? 'post' :'user.post', params: {postSlug: comment.post.slug, slug: comment.post.category ? comment.post.category.slug : comment.user.slug}}"
                  :title="comment.post.title">
                  <span>{{ comment.post.short_title }}</span>
                </router-link>
              </div>
              <div v-else>
                <div class="live-lenta">
                  <new-reply-comment v-if="comment.type === 'App\\Notifications\\AddReplyCommentNotification'" :item="comment" :isLenta="true"/>
                  <new-comment v-if="comment.type === 'App\\Notifications\\AddCommentNotification'" :item="comment" :isLenta="true"/>
                  <like-comment v-if="comment.type === 'App\\Notifications\\AddLikeToCommentNotification'" :item="comment" :isLenta="true"/>
                  <new-post v-if="comment.type === 'App\\Notifications\\AddPostNotification'" :item="comment" :isLenta="true"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from "../plugins/event-bus";
import axios from "axios";
import {mapGetters} from "vuex";
import NewReplyComment from "./Blocks/Notifications/NewReplyComment";
import NewComment from "./Blocks/Notifications/NewComment";
import NewFollow from "./Blocks/Notifications/NewFollow";
import LikeComment from "./Blocks/Notifications/LikeComment";
import NewPost from "./Blocks/Notifications/NewPost";

export default {
  name: "LiveLenta",
  components: {NewPost, LikeComment, NewFollow, NewComment, NewReplyComment},
  data() {
    return {
      show: true,
      hideLive: false,
      comments: {}
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
  methods: {
    get() {
      axios.get('/api/live-lenta').then((response) => {
        this.comments = response.data
      })
    },
  },
  mounted() {
    EventBus.$on('hideLive', () => {
      this.show = !this.show;
    });
    EventBus.$on('addNotification', (data) => {
      this.comments.unshift(data.notification)
    });

    let subs = this.user ? this.user.subscriptions : window.config.categories;

    for (const [key, value] of Object.entries(subs)) {
      Echo.channel('new-comment.' + value.id).notification(notification => {
        this.comments.unshift(notification.comment)
      });
    }
  },
  created() {
    this.get()
  }
}
</script>

<style scoped>
.layout__right-column-hide {
  width: 80px;
}

.live-hide {
  width: auto;
}

.live__caption_border-hide::after {
  display: none;
}

</style>
