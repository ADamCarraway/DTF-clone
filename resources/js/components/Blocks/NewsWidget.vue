<template>
  <div class="news_widget l-island-bg l-island-a l-island-round l-mb-15 l-pv-20 lm-pv-18 l-fs-16">

    <div class="news_widget__toggle t-no_select l-fs-13"  @click="show = !show">
      <i class="el-icon-arrow-up" v-if="show"></i>
      <i class="el-icon-arrow-down" v-if="!show"></i>
      <span class="news_widget__toggle__open" v-if="!show">развернуть</span>
      <span class="news_widget__toggle__close" v-if="show">свернуть</span>
    </div>

    <div class="news_widget__header">
      <p class="l-fs-16 lm-fs-15 t-ff-1-700">{{ date }}</p>
    </div>

    <div class="news_widget__content" v-if="show && posts">
      <div class="news_widget__content__inner">
        <div class="news_item l-flex l-fa-baseline lm-block l-mv-9 lm-mv-8" v-for="p in posts" :key="p.id">
          <time class="time" v-if="now === p.dateDay">{{ p.dateHour}}</time>
          <time class="time" v-else>{{ p.dateDay }}</time>
          <div class="l-inline">
            <router-link
              :to="{ name: 'post' , params: {postSlug: p.slug, slug: p.category.slug} }"
              class="news_item__title t-link l-fs-16 l-lh-24 l-mr-8">
              {{ p.title }}
            </router-link>

            <div
              class="comments_counter comments_counter--nonzero comments_counter--small">
              <a class="comments_counter__count t-link">

                <span class="comments_counter__count__value_new"></span>

                <span class="comments_counter__count__ico">
                  <ion-icon src="/icons/chatbubble-outline.svg" style="transform: scale(-1, 1);"></ion-icon>
                </span>
                <span class="comments_counter__count__value">{{ p.comments_count }}</span>

              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="news_widget__footer" v-if="show && !done">
      <p class="news_widget__load_more t-ff-1-700 l-fs-16 lm-fs-15 t-link" @click="getData()">
        <span>Показать ещё</span>
        <i class="el-icon-arrow-down"></i>
      </p>

      <span class="ui_preloader "></span>
    </div>

  </div>
</template>

<script>
  import axios from "axios";
  import moment from "moment";

  export default {
    name: "NewsWidget",
    data() {
      return {
        show: true,
        posts: [],
        page: 1,
        done: false,
        date: null
      }
    },
    computed:{
      now(){
        return moment().format('MM.DD');
      }
    },
    methods: {
      getData() {
        if (this.done) return;

        axios.get('/api/news?page='+ this.page).then((response) => {
          this.date = response.data.currentDate;
          this.posts = this.posts.concat(response.data.data);
          this.page += 1;

          if (response.data.to === response.data.total) this.done = true;
        });
      }
    },
    created() {
      this.getData()
    }
  }
</script>

<style scoped>

</style>
