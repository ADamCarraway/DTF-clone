<template>
  <div v-if="data">
    <details-subs :data="data.users" :type="'users'"></details-subs>
    <details-regulations :data="data.rules"></details-regulations>
  </div>
</template>

<script>
  import DetailsSubs from "./Blocks/DetailsSubs";
  import DetailsRegulations from "./Blocks/DetailsRegulations";
  import axios from "axios";

  export default {
    name: "CategoryAllDetails",
    components: {DetailsRegulations, DetailsSubs},
    data(){
      return{
        data: null
      }
    },
    methods: {
      getData(slug) {
        axios.get('/api/'+slug+'/details').then((res) => {
          this.data = res.data;
        })
      }
    },
    created() {
      this.getData(this.$route.params.slug)
    }
  }
</script>

<style scoped>

</style>
