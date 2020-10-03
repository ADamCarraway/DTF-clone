<template>
  <div v-if="data">
    <details-subs :data="data.subscribers" :type="'users'"></details-subs>
    <details-subs :data="data.subscriptions" :type="'categories'"></details-subs>
  </div>
</template>

<script>
  import axios from "axios";
  import DetailsSubs from "./Blocks/DetailsSubs";

  export default {
    name: "UserAllDetails",
    components: {DetailsSubs},
    data(){
      return{
        data: null
      }
    },
    methods: {
      getData(slug) {
        axios.get('/api/u/'+slug+'/details').then((res) => {
          this.data = res.data;
        })
      }
    },
    created() {
      this.getData(this.$route.params.slug);
    }
  }
</script>

<style scoped>

</style>
