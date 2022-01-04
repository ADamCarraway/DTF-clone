<template>
  <div class="content-footer content-footer--short l-island-a">

    <div class="content-footer__left">

      <!-- Comments -->
      <div class="content-footer__item">

        <div
          class="comments_counter comments_counter--nonzero comments_counter--num comments_counter--has_new l-inline-block l-fs-0">
          <router-link
            :to="{ name: data.category ? 'post' :'user.post', params: {postSlug: data.slug, slug: data.category ? data.category.slug : data.user.slug} }"
            class="comments_counter__count t-link">
                <span class="comments_counter__count__ico l-inline-block l-va-middle l-lhr-1">
                  <ion-icon name="chatbubble-outline" style="transform: scale(-1, 1);"></ion-icon>
                </span>
            <span class="comments_counter__count__value l-inline-block l-va-middle">{{ data.comments_count}}</span>
          </router-link>
        </div>
      </div>

      <!-- Favorite -->
      <div class="content-footer__item">
        <bookmark :data="data"/>
      </div>

      <repost :data="data"/>

      <!-- Share -->
      <share :data="data"/>
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
  import Share from "../Buttons/Share";
  import Repost from "../Buttons/Repost";

  export default {
    name: "PostFooter",
    components: {Repost, Share, Like, Bookmark},
    props: ['data']
  }
</script>

<style scoped>

</style>
