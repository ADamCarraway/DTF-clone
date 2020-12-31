<template>
  <div class="page page--index ">
    <news-widget/>
    <div class="app--content-feed">
      <posts-filter :routes='{index: "index", new: "index.new"}'></posts-filter>
      <posts-list v-if="data" :data="data" :url="'/api/posts'"></posts-list>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import CreatePostBlock from "../components/Blocks/CreatePostBlock";
  import PostsList from "../components/PostsList";
  import PostsFilter from "../components/PostsFilter";
  import EventBus from "../plugins/event-bus";
  import NewsWidget from "../components/Blocks/NewsWidget";

  export default {
    components: {NewsWidget, PostsFilter, PostsList, CreatePostBlock},
    data() {
      return {
        data: []
      }
    },
    methods: {},
    metaInfo() {
      return {title: 'Def'}
    }
  }
</script>
