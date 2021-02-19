<template>
  <div>
    <div class="ui-tabs ui-tabs--small ui-border--bottom l-island-round l-island-bg" style="    margin-bottom: 13px;">
      <div class="ui-tabs__scroll">
        <div class="ui-tabs__content l-island-a">
          <router-link  :to="{ name: 'user.favorites'}" class="ui-tab" :class="{'ui-tab--active': $route.name === 'user.favorites'}">
            <span class="ui-tab__label">
              Статьи
              <span class="ui-tab__counter ">{{ postTotal }}</span>
            </span>
          </router-link>
          <router-link :to="{ name: 'user.favorites.comments'}" class="ui-tab" :class="{'ui-tab--active': $route.name === 'user.favorites.comments'}">
            <span class="ui-tab__label">Комментарии
              <span class="ui-tab__counter ">{{ commentsTotal}}</span>
            </span>
          </router-link>
        </div>
      </div>
    </div>
    <div class="feed">
      <div class="feed__container">
        <div class="feed__chunk">
          <div v-for="item in data" :key="item.slu" class="feed__item l-island-round"
               :class="{'comment_favorite': $route.name === 'user.favorites.comments', 'post_favorite': $route.name === 'user.favorites'}">
            <user-comment-block :data="item" v-if="filter === 'comments'"/>
            <post :data="item" v-else/>
          </div>
        </div>
        <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
          <div slot="no-results">
            <div class="subsite_content_dummy l-island-a l-island-bg l-fs-15 l-lh-22 l-ta-center">
              <div class="subsite_content_dummy__title l-fw-600">
                <span v-if="filter === 'comments'">Нет комментариев в закладках</span>
                <span v-else>Нет статей в закладках</span>
              </div>
              <div class="subsite_content_dummy__text l-mt-5">
                <span v-if="filter === 'comments'">Если вы прочли полезный комментарий, то нет ничего лучше, чем добавить его в закладки</span>
                <span v-else>Как только вам понравится статья, не раздумывая жмите на закладку!</span>
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
  import InfiniteLoading from "vue-infinite-loading";
  import axios from "axios";
  import Comment from "../../components/Blocks/Comment";
  import UserCommentBlock from "../../components/Blocks/UserCommentBlock";
  import Post from "../../components/Blocks/Post";

  export default {
    name: "favorites",
    middleware: 'private',
    components: {Post, UserCommentBlock, Comment, InfiniteLoading},
    data() {
      return {
        filter: this.$route.name.indexOf('.comments') + 1 ? 'comments' : 'posts',
        data: [],
        page: 1,
        infiniteId: +new Date(),
        postTotal: 0,
        commentsTotal: 0
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.filter = to.name.indexOf('.comments') + 1 ? 'comments' : 'posts';
        vm.data = [];
        vm.page = 1;
        vm.infiniteId += 1;
      });
    },
    methods: {
      infiniteHandler($state) {
        axios.get('/api/u/' + this.$route.params.slug + '/favorites?filter=' + this.filter + '&page=' + this.page)
          .then((data) => {
            if (data.data.postTotal){
              this.postTotal = data.data.postTotal
            }

            if (data.data.commentsTotal){
              this.commentsTotal = data.data.commentsTotal
            }

            if (data.data.favorites.data.length) {
              this.page = this.page + 1;
              $.each(data.data.favorites.data, (key, value) => {
                this.data.push(value);
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

