<template>
  <div class="l-page__content">
    <div class="l-mb-20" v-if="data.type === 'category' || data.id === user.id">
      <create-post-block :user="user" :data="data"></create-post-block>
    </div>
    <posts-filter :routes='{index: data.type, new: data.type+".new"}'></posts-filter>
    <posts-list v-if="data.slug" :data="data" :url="['user', 'user.new'].includes(this.$route.name) ? '/api/u/' + data.slug + '/posts' : '/api/' + data.slug + '/posts'"></posts-list>
  </div>
</template>

<script>
  import CreatePostBlock from "../Blocks/CreatePostBlock";
  import {mapGetters} from "vuex";
  import PostsList from "../PostsList";
  import PostsFilter from "../PostsFilter";

  export default {
    name: "UserPosts",
    props:['data'],
    components: {PostsFilter, PostsList, CreatePostBlock},
    computed: mapGetters({
      user: 'auth/user',
    }),
  }
</script>

<style scoped>

</style>
