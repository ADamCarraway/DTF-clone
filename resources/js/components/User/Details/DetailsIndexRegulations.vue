<template>
  <div v-if="data" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      Правила
    </span>
    </div>
    <div class="v-list v-list--text">
      <div v-if="data.regulations" class="v-list__content" v-html="data.regulations"></div>
      <div v-else class="v-island__grayed">Строгих правил нет. Но ведите себя хорошо 😉</div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "DetailsIndexRegulations",
    data() {
      return {
        data: {}
      }
    },
    methods: {
      getData(slug) {
        this.data = window.config.categories[slug]
      }
    },
    created() {
      this.getData(this.$route.params.slug)
    }
  }
</script>

<style scoped>

</style>
