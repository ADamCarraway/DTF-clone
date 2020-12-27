<template>
  <div class="feed__item l-island-round">

    <div class="l-mb-28 lm-mb-20 content-feed content-feed--games content-feed--225339 l-island-bg l-island-round">

      <div class="content-header content-header--short">
        <div class="l-pt-20"></div>
        <div class="content-header__info l-island-a">

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
                         class="content-header-author content-header-author--subsite content-header__item">
              <div  v-if="!data.category" class="content-header-author__avatar">

                <img class="andropov_image  andropov_image--bordered"
                     :src="data.user.avatar">
              </div>

              <div class="content-header-author__name">
                {{ data.user.name }}
              </div>

            </router-link>

            <!-- Время публикации -->
            <div class="content-header-number content-header__item">
              <a
                href="https://dtf.ru/games/225339-kooperativnyy-rezhim-legends-dlya-ghost-of-tsushima-vyydet-16-oktyabrya"
                class="t-link">
                <span class="time">{{ data.date }}</span>
              </a>
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

        <h2 class="content-header__title l-island-a" v-if="data.title">
          {{ data.title }}
          <a href="#">
    <span class="content-editorial-tick">
     <i class="fas fa-check"></i>
    </span>
          </a>

        </h2>

      </div>


      <div class="content content--short  ">
        <div  class="l-island-a" v-html="html[0]">
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

      </div>


      <div class="content-footer content-footer--short l-island-a">

        <div class="content-footer__left">

          <!-- Comments -->
          <div class="content-footer__item">

            <div
              class="comments_counter comments_counter--nonzero comments_counter--num comments_counter--has_new l-inline-block l-fs-0">
              <a
                href="https://dtf.ru/games/225339-kooperativnyy-rezhim-legends-dlya-ghost-of-tsushima-vyydet-16-oktyabrya?comments"
                class="comments_counter__count t-link">
                <span class="comments_counter__count__ico l-inline-block l-va-middle l-lhr-1">
                 <i class="far fa-comments l-fs-20"></i>
                </span>
                <span class="comments_counter__count__value l-inline-block l-va-middle">89</span>
              </a>
            </div>
          </div>

          <!-- Favorite -->
          <div class="content-footer__item">
            <bookmark :data="data"/>
          </div>

          <!-- Repost (all checks are inside) -->

          <div class="repost_button">

            <div class="repost_button__button " title="Сделать репост">
              <i class="fas fa-retweet l-fs-20"></i>
              <div class="repost_button__counter l-ml-4"></div>
            </div>

            <div class="repost_button__list"></div>

          </div>

        </div>

        <div class="content-footer__right">

          <!-- Vote -->
          <div class="content-footer__item">
            <like :data="data"/>
          </div>

        </div>

      </div>
      <a class="content-feed__link"
         href="https://dtf.ru/games/225339-kooperativnyy-rezhim-legends-dlya-ghost-of-tsushima-vyydet-16-oktyabrya"></a>
    </div>
  </div>
</template>

<script>
  import Like from "../Buttons/Like";
  import Bookmark from "../Buttons/Bookmark";
  import edjsHTML from "editorjs-html"

  export default {
    name: "Post",
    components: {Bookmark, Like},
    props: ['data'],
    data(){
      return {
        html : ''
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
