<template>
  <div class="l-island-bg  l-island-round">
    <div class="">
      <post v-for="item in data" :data="item" :key="item.id"></post>
    </div>
    <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
      <div slot="no-results">
        <div class="l-island-bg v-island">
          <div class="v-island__dummy">
            Черновиков нет!
          </div>
        </div>
      </div>
      <div slot="no-more"></div>
    </infinite-loading>
  </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import axios from "axios";
import Post from "../../components/Blocks/Post";

export default {
  name: "UserNotifications",
  components: {Post, InfiniteLoading},
  data() {
    return {
      data: [],
      page: 1,
      infiniteId: +new Date(),
    }
  },
  methods: {
    infiniteHandler($state) {
      axios.get('/api/drafts?page=' + this.page)
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
