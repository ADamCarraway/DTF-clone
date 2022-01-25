<template>
  <div class="a-posts">
    <div class="post-block" v-for="comment in user.comments">
      <router-link
          :to="{ name: comment.post.category_id ? 'post' :'user.post', params: {postSlug: comment.post.slug, slug: comment.post.category_id ? comment.post.category.slug : user.slug} }"
          class="profile_comment_favorite__title">
        <span>{{ comment.post.short_title }}</span>
        <time class="content-header-number content-header__item d-inline-block">{{ comment.date }}</time>
      </router-link>
      <div class="profile_comment_favorite__text ">
      <span class="profile_comment_favorite__text__full">
        <p>{{ comment.comment }}</p>
      </span>
      </div>
      <div class="mt-1 d-flex justify-content-start">
        <div class="stats-item">
          <ion-icon name="heart-outline"></ion-icon>
          {{ comment.likes_count }}
        </div>
        <div class="stats-item">
          <ion-icon name="bookmark-outline"></ion-icon>
          {{ comment.bookmarks_count }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: 'LastComments',

  props: ['user'],
  methods: {}
}
</script>
