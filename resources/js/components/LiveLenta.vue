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
                mamamamamama
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

export default {
  name: "LiveLenta",
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
      if (data.notification.type === 'App\\Notifications\\LiveLentaAddCommentNotification'){
        this.comments.unshift(data.notification.comment)
      }else{
        this.comments.unshift(data.notification)
      }
    });
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
