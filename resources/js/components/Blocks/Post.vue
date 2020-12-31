<template>
  <div class="feed__item l-island-round" v-if="data.slug">

    <div class="l-mb-28 lm-mb-20 content-feed content-feed--games content-feed--225339 l-island-bg l-island-round">

      <div class="content-header content-header--short">
        <div class="content-header__info l-island-a" :class="{'content-header--empty-title': !data.title}">

          <div class="content-header__left">

            <!-- Подсайт, в котором опубликована статья -->
            <router-link v-if="data.category" :to="{ name: 'category', params: {slug: data.category.slug} }"
                         class="content-header-author content-header-author--subsite content-header__item">
              <div class="content-header-author__avatar">

                <img class="andropov_image  andropov_image--bordered"
                     :src="data.category.icon">
              </div>

              <div class="content-header-author__name">
                {{ data.category.title }}
              </div>

            </router-link>

            <!-- Автор -->
            <router-link v-if="data.user" :to="{ name: 'user', params: {slug: data.user.slug} }"
                         class="content-header-author content-header__item"
                         :class="{'content-header-author--subsite': !data.category}">
              <div v-if="!data.category" class="content-header-author__avatar">

                <img class="andropov_image  andropov_image--bordered"
                     :src="data.user.avatar">
              </div>

              <div class="content-header-author__name">
                {{ data.user.name }}
              </div>

            </router-link>

            <!-- Время публикации -->
            <div class="content-header-number content-header__item">
              <span class="time">{{ data.date }}</span>
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
        <router-link class="content-header__title l-island-a" v-if="data.title"
                     :to="{ name: data.category ? 'post' :'user.post', params: {postSlug: data.slug, slug: data.category ? data.category.slug : data.user.slug} }">
          {{ data.title }}
          <span class="l-no-wrap">
            <router-link
              :to="{ name: data.category ? 'post' :'user.post', params: {postSlug: data.slug, slug: data.category ? data.category.slug : data.user.slug} }">
              <span class="content-editorial-tick">
                 <i class="fas fa-check"></i>
              </span>
            </router-link>
          </span>
        </router-link>
      </div>


      <router-link
        :to="{ name: data.category ? 'post' :'user.post', params: {postSlug: data.slug, slug: data.category ? data.category.slug : data.user.slug} }"
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


      <post-footer :data="data"/>
    </div>
  </div>
</template>

<script>
  import Like from "../Buttons/Like";
  import Bookmark from "../Buttons/Bookmark";
  import edjsHTML from "editorjs-html"
  import PostFooter from "./PostFooter";

  export default {
    name: "Post",
    components: {PostFooter, Bookmark, Like},
    props: ['data'],
    data() {
      return {
        html: ''
      }
    },
    created() {
      let test = new edjsHTML()
      this.html = test.parse({
        blocks: JSON.parse(this.data.blocks)
      });
    }
  }
</script>

<style scoped>

</style>
