<template>
  <div class="feed__item l-island-round" v-if="post && post.slug">

    <div class="l-mb-28 lm-mb-20 content-feed l-island-bg l-island-round">

      <div class="content-header-repost l-island-a" v-if="data.parent_id">
        <ion-icon src="/icons/repeat-outline.svg"></ion-icon>
        <router-link v-if="data.user" :to="{ name: 'user', params: {slug: data.user.slug} }"
                     class="content-header-repost__name l-inline-block l-mr-4 l-relative l-z-1 t-link"
                     :title="data.user.name">
          {{ data.user.name }}
        </router-link>
        сделал репост
      </div>

      <div class="content-header content-header--short">
        <div class="content-header__info l-island-a" :class="{'content-header--empty-title': !post.title}">

          <div class="content-header__left">

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

          <div class="content-header__right">
            <!-- Бейдж черновика -->

            <!-- Управление статьей -->

            <div class="etc_control">
              <svg class="icon icon--ui_etc" width="18" height="8" xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="#ui_etc"></use>
              </svg>
            </div>

            <!-- Кнопка «Подписаться» -->
          </div>

        </div>
        <router-link class="content-header__title l-island-a" v-if="post.title"
                     :to="{ name: post.category ? 'post' :'user.post', params: {postSlug: post.slug, slug: post.category ? post.category.slug : post.user.slug} }">
          {{ post.title }}
          <span class="l-no-wrap" v-if="post.is_official">
            <router-link
              :to="{ name: post.category ? 'post' :'user.post', params: {postSlug: post.slug, slug: post.category ? post.category.slug : post.user.slug} }">
              <span class="content-editorial-tick">
                <ion-icon src="/icons/checkmark.svg"></ion-icon>
              </span>
            </router-link>
          </span>
        </router-link>
      </div>

      <router-link
        :to="{ name: post.category ? 'post' :'user.post', params: {postSlug: post.slug, slug: post.category ? post.category.slug : post.user.slug} }"
        class="content content--short  ">
        <div class="content content--content l-island-a" v-html="html[0]">
        </div>

        <!--        <figure>-->

        <!--          <div class="l-island-b">-->
        <!--            <div class="content-image">-->

        <!--              <div class="andropov_image andropov_image&#45;&#45;zoomable" style="max-height: 600px;max-width: 1274px;">-->

        <!--                <div class="andropov_image__inner" style="padding-bottom: 0px; background: transparent;"><img-->
        <!--                  src="https://leonardo.osnova.io/7a6199bd-6fdf-228e-2758-e7b8a019074c/-/resize/700/"></div>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--          </div>-->


        <!--        </figure>-->

      </router-link>

      <post-footer :data="post"/>
    </div>
  </div>
</template>

<script>
  import Like from "../Buttons/Like";
  import Bookmark from "../Buttons/Bookmark";
  import edjsHTML from "editorjs-html"
  import PostFooter from "./PostFooter";
  import moment from "moment";

  export default {
    name: "Post",
    components: {PostFooter, Bookmark, Like},
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
      let test = new edjsHTML()
      this.html = test.parse({
        blocks: JSON.parse(this.post.blocks)
      });
    }
  }
</script>

<style scoped>

</style>
