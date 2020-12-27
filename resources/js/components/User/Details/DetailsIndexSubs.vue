<template>
  <div v-if="data" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      {{ title }}
    </span>
      <span class="v-island__counter" v-if="total">
      {{ total }}
    </span>
    </div>
    <div class="v-list-subsites">
      <div class="v-list-subsites__content v-list-subsites__content--columns-1">
        <div v-for="item in data" :key="item.slug" class="v-list-subsites-item">
          <router-link :to="{ name: item.type, params: {slug: item.slug} }"
                       class="v-list-subsites-item__main">
            <div class="v-list-subsites-item__image"
                 lazy="loaded"
                 :style="{ backgroundImage: `url('${item.icon}')` }">

            </div>
            <div class="v-list-subsites-item__label">
              {{ item.title }}
            </div>
          </router-link>
          <div class="v-subscribe-button v-subscribe-button--short v-subscribe-button--state-inactive">
            <subscribe v-if="user && item.id !== user.id" :data="item"></subscribe>
          </div>

        </div>

        <infinite-loading :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
          <div slot="no-more"></div>
        </infinite-loading>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import {mapGetters} from "vuex";
  import Subscribe from "../../Buttons/Subscribe";
  import InfiniteLoading from "vue-infinite-loading";

  export default {
    name: "DetailsIndexSubs",
    components: {Subscribe, InfiniteLoading},
    data() {
      return {
        data: [],
        url: '',
        page: 1,
        total: 0,
        infiniteId: +new Date(),
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
      title: function () {
        return this.$route.name === 'user.subscribers' || this.$route.name === 'category.subscribers' ? 'Подписчики' : 'Подписки';
      },
    },
    // beforeRouteEnter(to, from, next) {
    //   next(vm => {
    //     vm.data = [];
    //     vm.page = 1;
    //     vm.infiniteId += 1;
    //   });
    // },
    // beforeRouteUpdate (to, from, next) {
    //   this.data = [];
    //   this.page = 1;
    //   this.infiniteId += 1;
    //   next()
    // },
    beforeRouteLeave(to, from, next) {
      this.data = [];
      this.page = 1;
      this.total = 0;
      this.infiniteId += 1;
      next();
    },
    methods: {
      getData() {
        this.setUrl();
        axios.get(this.url).then((res) => {
          this.data = res.data.data;
        })
      },
      setUrl() {
        if (this.$route.name === 'user.subscribers') {
          this.url = '/api/u/' + this.$route.params.slug + '/details/subscribers';
        } else if (this.$route.name === 'user.subscriptions') {
          this.url = '/api/u/' + this.$route.params.slug + '/details/subscriptions';
        } else {
          this.url = '/api/' + this.$route.params.slug + '/details/subscribers';
        }
      },
      infiniteHandler($state) {
        this.setUrl();

        Vue.http.get(this.url + '?page=' + this.page)
          .then((data) => {
            if (data.data.data.length) {
              this.page = this.page + 1;
              this.total = data.data.total;
              $.each(data.data.data, (key, value) => {
                this.data.push(value);
              });

              $state.loaded();
            } else {
              $state.complete();
            }
          });
      },
    },
  }
</script>

<style scoped>

</style>

