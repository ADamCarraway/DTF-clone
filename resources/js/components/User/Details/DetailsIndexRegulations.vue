<template>
  <div class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      Правила
    </span>
    </div>
    <div class="v-list v-list--text">
      <div v-if="regulation" class="v-list__content" v-html="regulation"></div>
      <div v-else class="v-island__grayed">Строгих правил нет. Но ведите себя хорошо 😉</div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "DetailsIndexRegulations",
    data() {
      return {
        regulation: ''
      }
    },
    methods: {
      getData(slug) {
        axios.get('/api/subs/'+slug+'/regulation')
          .then((data) => {
            this.regulation = data.data
          });
      }
    },
    created() {
      this.getData(this.$route.params.slug)
    }
  }
</script>

<style scoped>

</style>
