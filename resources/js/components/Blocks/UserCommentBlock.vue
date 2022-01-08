<template>
  <div class="profile_comment_favorite l-island-a l-island-bg l-island-round l-mb-28 lm-mb-20">
    <router-link :to="{ name: data.post.category_id ? 'post' :'user.post', params: {postSlug: data.post.slug, slug: data.post.category_id ? data.post.category.slug : data.user.slug} }"  class="profile_comment_favorite__title">
      <span>{{ data.post.title }}</span>
    </router-link>
    <div class="profile_comment_favorite__header">
      <router-link  :to="{ name: 'user', params: {slug: data.user.slug} }" class="profile_comment_favorite__user">
        <img class="andropov_image profile_comment_favorite__user__image" :src="data.user.avatar" style="background-color: transparent;">
        <p class="profile_comment_favorite__user__name">{{ data.user.name }}</p>
      </router-link>
      <div class="profile_comment_favorite__date t-link">
        <time class="time">{{ data.date}}</time>
      </div>
    </div>
    <div class="profile_comment_favorite__text ">
      <span class="profile_comment_favorite__text__full">
        <p>{{ data.comment }}</p>
      </span>
    </div>
    <div class="profile_comment_favorite__footer">

      <bookmark :data="data"/>

      <like :data="data" class="comments__item__like"/>
    </div>
  </div>
</template>

<script>
  import Bookmark from "../Buttons/Bookmark";
  import Like from "../Buttons/Like";
  export default {
    name: "UserCommentBlock",
    components: {Like, Bookmark},
    props: ['data']
  }
</script>

<style scoped>

</style>
