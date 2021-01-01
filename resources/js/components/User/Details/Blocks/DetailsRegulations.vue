<template>
  <div v-if="data" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      Правила
    </span>
    </div>
    <div class="v-list v-list--text">
      <div class="v-list__content" v-html="data"></div>
      <router-link :to="{ name: 'category.rules' }"  class="v-list__more">
        Показать все
      </router-link>
    </div>
  </div>
</template>

<script>
  export default {
    name: "DetailsRegulations",
    props: ['data']
  }
</script>

<style scoped>

</style>
