<template>
  <div class="a-posts">
    <div class="post-block" v-for="post in user.posts">
      <div class="content-header__info mb-1">
        <router-link v-if="post.category" :to="{ name: 'category', params: {slug: post.category.slug} }"
                     class="content-header-author content-header-author--subsite content-header__item">
          <div class="content-header-author__name">
            {{ post.category.title }}
          </div>

        </router-link>
        <span class="content-header-author content-header__item" v-if="!post.category">
        <div class="content-header-author__name">Блог</div>
      </span>
        <div class="content-header-number content-header__item">
          <span class="time">{{ post.date }}</span>
        </div>
        <div class="content-header__item content-header-label content-header-label--draft" v-if="!post.is_publish">Черновик</div>
      </div>
      <router-link class="content-title content-title--short" v-if="post.title"
                   :to="{ name: post.category ? 'post' :'user.post', params: {postSlug: post.slug, slug: post.category ? post.category.slug : post.user.slug} }">
        {{ post.title }}
        <span class="l-no-wrap" v-if="post.is_official">
            <router-link
                :to="{ name: post.category ? 'post' :'user.post', params: {postSlug: post.slug, slug: post.category ? post.category.slug : post.user.slug} }">
              <span class="content-editorial-tick">
                <ion-icon name="checkmark"></ion-icon>
              </span>
            </router-link>
          </span>
      </router-link>
      <div class="mt-1 d-flex justify-content-start">
        <div class="stats-item">
          <ion-icon name="chatbubbles-outline"></ion-icon> {{post.comments_count}}
        </div>
        <div class="stats-item">
          <ion-icon name="heart-outline"></ion-icon> {{post.likes_count}}
        </div>
        <div class="stats-item">
          <ion-icon name="bookmark-outline"></ion-icon> {{post.bookmarks_count}}
        </div>
        <div class="stats-item">
          <ion-icon name="sync-outline"></ion-icon> {{post.repost_count}}
        </div>
        <div class="stats-item">
          <ion-icon name="eye-outline"></ion-icon> {{post.unique_views_count}}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: 'LastPosts',

  props: ['user'],
  methods: {}
}
</script>
