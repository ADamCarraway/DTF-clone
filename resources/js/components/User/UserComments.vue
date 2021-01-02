<template>
  <div>
    <posts-filter :routes='{index: "user.comments", new: "user.comments.new"}'></posts-filter>
    <div class="feed">
      <div class="feed__container">
        <div class="feed__chunk">
          <!--for-->
          <div  v-for="item in data" :key="item.id" class="feed__item l-island-round">
            <div class="profile_comment_favorite l-island-a l-island-bg l-island-round l-mb-28 lm-mb-20">
              <comment :data="item" :type="'userComments'"/>
            </div>
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
  import PostsFilter from "../PostsFilter";
  import InfiniteLoading from "vue-infinite-loading";
  import axios from "axios";
  import EventBus from "../../plugins/event-bus";
  import Comment from "../Blocks/Comment";

  export default {
    name: "UserComments",
    components: {Comment, PostsFilter, InfiniteLoading},
    data(){
      return{
        filter: this.$route.name.indexOf('.new') + 1 ? 'new' : 'popular',
        data: [],
        page: 1,
        infiniteId: +new Date(),
      }
    },
    mounted() {
      EventBus.$on('changeCommentsRoute', (filter) => {
        this.filter = filter;
        this.data = [];
        this.page = 1;
        this.infiniteId += 1;
      });
    },
    methods: {
      infiniteHandler($state) {
        axios.get('/api/u/'+this.$route.params.slug+'/comments?filter='+this.filter+'&page=' + this.page)
          .then((data) => {
            if (data.data.data.length) {
              this.page = this.page + 1;
              $.each(data.data.data, (key, value) => {
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
EventBus.$emit('changeCommentsRoute', filter)
