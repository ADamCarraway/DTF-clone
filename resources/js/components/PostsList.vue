<template>
  <div class="feed">
    <div class="feed__container">
      <div class="feed__chunk">
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

  export default {
    name: "PostsList",
    components: {Post, InfiniteLoading},
    data() {
      return {
        posts:[],
        url: '',
        page: 1,
        total: 0,
        infiniteId: +new Date(),
      }
    },
    methods: {
      setUrl(){
        let slug = this.$route.params.slug
        this.url = '/api/'+slug+'/posts';
      },
      infiniteHandler($state) {
        this.setUrl();

        Vue.http.get(this.url + '?page=' + this.page)
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
