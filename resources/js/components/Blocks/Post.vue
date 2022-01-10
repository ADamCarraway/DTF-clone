<template>
  <div class="feed__item l-island-round" v-if="post && post.slug">

    <div class="l-mb-28 lm-mb-20 content-feed l-island-bg l-island-round">

      <div class="content-header-repost l-island-a" v-if="data.parent_id">
        <ion-icon name="repeat-outline"></ion-icon>
        <router-link v-if="data.user" :to="{ name: 'user', params: {slug: data.user.slug} }"
                     class="content-header-repost__name l-inline-block l-mr-4 l-relative l-z-1 t-link"
                     :title="data.user.name">
          {{ data.user.name }}
        </router-link>
        сделал репост
      </div>

      <div class="content-header content-header--short l-island-a" :class="{'content-header--empty-title': !post.title}">

          <div class="content-header__info">

            <!-- Подсайт, в котором опубликована статья -->
            <router-link v-if="post.category" :to="{ name: 'category', params: {slug: post.category.slug} }"
                         class="content-header-author content-header-author--subsite content-header__item">
              <div class="content-header-author__avatar">

                <img class="andropov_image  andropov_image--bordered"
                     :src="post.category.icon">
              </div>

              <div class="content-header-author__name">
                {{ post.category.title }}
              </div>

            </router-link>

            <!-- Автор -->
            <router-link v-if="post.user" :to="{ name: 'user', params: {slug: post.user.slug} }"
                         class="content-header-author content-header__item"
                         :class="{'content-header-author--subsite': !post.category}">
              <div v-if="!post.category" class="content-header-author__avatar">

                <img class="andropov_image  andropov_image--bordered"
                     :src="post.user.avatar">
              </div>

              <div class="content-header-author__name">
                {{ post.user.name }}
              </div>

            </router-link>

            <!-- Время публикации -->
            <div class="content-header-number content-header__item">
              <span class="time">{{ post.date }}</span>
            </div>

            <!-- Закрепленный пост -->

            <!-- Пометка у спонсорских постов -->

          </div> 
          <div class="content-header__spacer"></div>
          <div class="content-header__item content-header-label content-header-label--draft" v-if="!post.is_publish">Черновик</div>
          <div class="content-header__item content-header__item--controls">
            <!-- Управление статьей -->
            <post-management :data="post"></post-management>

            <!-- Кнопка «Подписаться» -->
          </div>

        </div>
      <div class="content content--short">
        <div class="content-container">
          <router-link class="content-title content-title--short l-island-a" v-if="post.title"
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
        </div>
      </div>

      <router-link
        :to="{ name: post.category ? 'post' :'user.post', params: {postSlug: post.slug, slug: post.category ? post.category.slug : post.user.slug} }"
        class="content content--short  ">
        <div class=" content content--short " v-html="html" v-if="html">
        </div>

      </router-link>

      <post-footer :class="'content-footer--short'" :data="post"/>
    </div>
  </div>
</template>

<script>
  import Like from "../Buttons/Like";
  import Bookmark from "../Buttons/Bookmark";
  import edjsHTML from "editorjs-html"
  import PostFooter from "./PostFooter";
  import moment from "moment";
  import PostManagement from "./PostManagement";

  const {editorParseToHtml} = require("../../helpers");

  export default {
    name: "Post",
    components: {PostManagement, PostFooter, Bookmark, Like},
    props: ['data'],
    data() {
      return {
        html: ''
      }
    },
    computed:{
      post() {
        return this.data.parent_id ? this.data.parent : this.data
      }
    },
    created() {
      this.html = editorParseToHtml(this.post.blocks, true)
    }
  }
</script>

<style scoped>

</style>
