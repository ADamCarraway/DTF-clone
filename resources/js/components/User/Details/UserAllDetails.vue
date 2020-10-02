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
      getData(id) {
        axios.get('/api/u/'+id+'/details').then((res) => {
          this.data = res.data;
        })
      }
    },
    created() {
      this.getData(this.$route.params.id)
    }
  }
</script>

<style scoped>

</style>
