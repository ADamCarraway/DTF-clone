<template>
  <div class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="preloader preloader-island__title v-island__title"></span>
      <span class="preloader preloader-counter v-island__counter">0</span>
    </div>
    <div class="v-list-subsites">
      <div class="v-list-subsites__content v-list-subsites__content--columns-2">
        <div v-for="item in data" :key="item" class="v-list-subsites-item">
          <div class="v-list-subsites-item__main">
            <div class="preloader v-list-subsites-item__image" lazy="loaded"></div>
            <div class="preloader preloader-island__title v-list-subsites-item__label"></div>
          </div>
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
    name: "DetailsSubPreBlock",
    data() {
      return {
        data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
      }
    }
  }
</script>

<style scoped>

</style>
