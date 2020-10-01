<template>
  <div v-if="data">
    <details-subs :data="data.users"></details-subs>
    <details-regulations :data="data.rules"></details-regulations>
  </div>
</template>

<script>
  import DetailsSubs from "./Blocks/DetailsSubs";
  import DetailsRegulations from "./Blocks/DetailsRegulations";
  import axios from "axios";

  export default {
    name: "AllDetails",
    components: {DetailsRegulations, DetailsSubs},
    data(){
      return{
        data:{users:{data:{}}, rules:{}}
      }
    },
    methods: {
      getData(slug) {
        axios.get('/api/'+slug+'/details').then((res) => {
          this.data = res.data;
          console.log(this.data)
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
