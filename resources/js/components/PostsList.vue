<template>
  <div class="feed">
    <div class="feed__container">
      <div class="feed__chunk page--index">
        <post v-for="item in posts" :data="item" :key="item.id"></post>
      </div>
    </div>
    <infinite-loading :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
      <div slot="no-more"></div>
    </infinite-loading>
  </div>
</template>

<script>
  import Post from "./Blocks/Post";
  import InfiniteLoading from "vue-infinite-loading";
  import EventBus from "../plugins/event-bus";
  import PostsFilter from "./PostsFilter";
  import axios from "axios";

  export default {
    name: "PostsList",
    props: ['data', 'url'],
    components: {PostsFilter, Post, InfiniteLoading},
    data() {
      return {
        type: 'top',
        posts: [],
        page: 1,
        total: 0,
        infiniteId: +new Date(),
      }
    },
    mounted() {
      EventBus.$on('changePostsRoute', (type) => {
        this.type = type;
        this.posts = [];
        this.page = 1;
        this.infiniteId += 1;
      });

      // EventBus.$on('filterPosts', () => {
      //   this.posts = [];
      //   this.page = 1;
      //   this.infiniteId += 1;
      // });
    },

    methods: {
      infiniteHandler($state) {
        axios.get(this.url+'?type='+this.type+'&page=' + this.page)
          .then((data) => {
            if (data.data.data.length) {
              this.page = this.page + 1;
              $.each(data.data.data, (key, value) => {
                this.posts.push(value);
              });

              $state.loaded();
            } else {
              $state.complete();
            }
          });
      },
    }

  }
</script>

<style scoped>

</style>
