<template>
  <div class="l-page__content">
    <div class="l-mb-20">
      <create-post-block :user="user"></create-post-block>
    </div>
    <posts-list></posts-list>
  </div>
</template>

<script>
  import CreatePostBlock from "../Blocks/CreatePostBlock";
  import {mapGetters} from "vuex";
  import PostsList from "../PostsList";

  export default {
    name: "UserPosts",
    components: {PostsList, CreatePostBlock},
    computed: mapGetters({
      user: 'auth/user',
    }),
  }
</script>

<style scoped>

</style>
