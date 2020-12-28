<template>
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
</template>

<script>
  import Bookmark from "../Buttons/Bookmark";
  import Like from "../Buttons/Like";
  export default {
    name: "PostFooter",
    components: {Like, Bookmark},
    props: ['data']
  }
</script>

<style scoped>

</style>
