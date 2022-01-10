<template>
  <div class="app--content-feed page page--index">
    <news-widget v-if="$route.name === 'index' || $route.name === 'index.all'"></news-widget>
    <create-post-block v-else/>

    <div class="app--content-feed">
      <div class="ui-sorting ui-sorting--with-tabs">
        <div class="v-tabs">
          <div class="v-tabs__scroll">
            <div class="v-tabs__content">
              <router-link :to="{ name: 'index' }" class="v-tab"
                           :class="{'v-tab--active': $route.name === 'index' || $route.name === 'index.new'}">
                <span class="v-tab__label">Моя лента</span>
              </router-link>
              <router-link :to="{ name: 'index.all' }" class="v-tab"
                           :class="{'v-tab--active': $route.name === 'index.all' || $route.name === 'index.all.new'}">
                <span class="v-tab__label">Весь сайт</span>
              </router-link>
            </div>
          </div>
        </div>

        <div class="ui-filters l-island-round ui-filters--responsive">
          <div class="ui-filters__inner">
            <div class="ui-rounded-button ui-rounded-button--responsive ui-rounded-button--has-active-child"
                 :class="{'ui-rounded-button--active': $route.name === 'index' || $route.name === 'index.all'}">
              <router-link :to="{ name: $route.name.replace(/.new/i, '') }" class="ui-rounded-button__link">
                Популярное
              </router-link>
            </div>
            <div class="ui-rounded-button ui-rounded-button--responsive"
                 :class="{'ui-rounded-button--active': $route.name === 'index.new' || $route.name === 'index.all.new'}">
              <router-link :to="{ name: $route.name+'.new' }" class="ui-rounded-button__link">
                Свежее
              </router-link>
            </div>
          </div>
        </div>
      </div>

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
  import Post from "../components/Blocks/Post";
  import InfiniteLoading from "vue-infinite-loading";

  export default {
    components: {Post, NewsWidget, PostsFilter, PostsList, CreatePostBlock, InfiniteLoading},
    data() {
      return {
        filter: this.$route.name.indexOf('.new') + 1 ? 'new' : 'popular',
        feed: this.$route.name.indexOf('.all') + 1 ? '/all' : '',
        posts: [],
        page: 1,
        total: 0,
        infiniteId: +new Date(),
      }
    },
    beforeRouteUpdate(to, from, next) {
      this.filter = to.name.indexOf('.new') + 1 ? 'new' : 'popular';
      this.feed = to.name.indexOf('.all') + 1 ? '/all' : '';
      this.posts = [];
      this.page = 1;
      this.infiniteId += 1;
      if (this.$route.name === 'index.new') EventBus.$emit('clearNewPosts')
      next()
    },
    methods: {
      isPopular() {
      },
      setFilter(filter, feed) {

      },
      infiniteHandler($state) {
        axios.get('/api/posts' + this.feed + '/' + this.filter + '?page=' + this.page)
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
    },
    mounted() {
      if (this.$route.name === 'index.new') EventBus.$emit('clearNewPosts')
    },
    metaInfo() {
      return {title: 'noCONTEXT — игры, кино, сериалы, разработка, сообщество'}
    }
  }
</script>
