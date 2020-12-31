<template>
  <div class="feed">
    <div class="feed__container">
      <div class="feed__chunk page--index">
        <post v-for="item in posts" :data="item" :key="item.id"></post>
      </div>
    </div>
    <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
      <div slot="no-results">
        <div class="l-island-bg v-island">
          <div class="v-island__dummy">
            Здесь еще нет публикаций
          </div>
        </div>
      </div>
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
        filter: this.$route.name.indexOf('.new') + 1 ? 'new' : 'popular',
        posts: [],
        page: 1,
        total: 0,
        infiniteId: +new Date(),
      }
    },
    mounted() {
      EventBus.$on('changePostsRoute', (filter) => {
        console.log('new ' + filter)
        this.filter = filter;
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
    // beforeRouteUpdate (to, from, next) {
    //   this.filter = this.$route.name.indexOf('.new') + 1 ? 'new' : 'popular';
    //   this.posts = [];
    //   this.page = 1;
    //   this.infiniteId += 1;
    //   next()
    // },
    methods: {
      infiniteHandler($state) {
        console.log('this '+this.filter)
        axios.get(this.url+'?filter='+this.filter+'&page=' + this.page)
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
  .v-island {
    --offset-x: var(--island-offset-x, 20px);
    padding: 15px var(--offset-x) 16px;
    font-size: 16px;
    line-height: 1.5em;
  }

  .v-island__dummy {
    text-align: center;
    padding: 84px 0;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-align: center;
    align-items: center;
  }
</style>
