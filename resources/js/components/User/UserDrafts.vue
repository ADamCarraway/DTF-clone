<template>
  <div class="  l-island-round">
    <post v-for="item in data" :data="item" :key="item.id"></post>
    <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
      <div slot="no-results">
        <div class="l-island-bg v-island l-island-round">
          <div class="v-island__dummy">
            <p class="l-mb-16">
              У вас нет черновиков            </p>

            <router-link :to="{name: 'editor'}" class="v-button v-button--default v-button--size-default">
              <span class="v-button__label">Создать запись</span>
            </router-link>
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
