<template>
  <div class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="preloader preloader-island__title v-island__title"></span>
      <span class="preloader preloader-counter v-island__counter">0</span>
    </div>

    <div class="v-list v-list--images">
      <div class="v-list__content">
        <div v-for="item in data" :key="item"
             class="v-list__item">
          <div class="preloader v-list__image" lazy="loaded"></div>
        </div>
      </div>

      <div class="preloader preloader-list__more v-list__more">
        Показать всех
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "SubscribersPreBlock",
    data() {
      return {
        data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
      }
    }
  }
</script>

<style scoped>

</style>
