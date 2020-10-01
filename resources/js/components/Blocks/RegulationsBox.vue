<template>
  <div class="l-island-bg l-island-round v-island">
    <div class="v-island__header"><span class="v-island__title">
      Правила
    </span></div>
    <div class="v-list v-list--text">
      <div class="v-list__content" v-html="data"></div>
    </div>
    <router-link :to="{ name: 'subsite.rules' }" class="v-list__more">
      Показать всех
    </router-link>
  </div>
</template>

<script>
  export default {
    name: "RegulationsBox",
    props: ['data']
  }
</script>

<style scoped>

</style>
