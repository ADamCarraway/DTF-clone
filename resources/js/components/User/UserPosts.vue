<template>
  <div class="l-page__content">
    <div class="l-mb-20">
      <create-post-block :user="user" :data="data"></create-post-block>
    </div>
    <posts-list v-if="data" :data="data"></posts-list>
  </div>
</template>

<script>
  import CreatePostBlock from "../Blocks/CreatePostBlock";
  import {mapGetters} from "vuex";
  import PostsList from "../PostsList";

  export default {
    name: "UserPosts",
    props:['data'],
    components: {PostsList, CreatePostBlock},
    computed: mapGetters({
      user: 'auth/user',
    }),
  }
</script>

<style scoped>

</style>
