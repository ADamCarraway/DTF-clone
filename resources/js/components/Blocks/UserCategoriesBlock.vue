<template>
  <div class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">Подписки</span>
      <span class="v-island__counter">{{ Object.keys(categories).length }}</span>
    </div>
    <div v-if="Object.keys(categories).length > 0" class="v-list v-list--default">
      <div class="v-list__content">
        <router-link v-for="(category, index) in categories" :to="{ name: 'subsite', params: { slug: category.slug } }"
                     :key="category.slug" v-if="index <= 4" class="v-list__item">
          <div class="v-list__image" :style="{ backgroundImage: `url('${category.icon}')` }" lazy="loaded"></div>
          <div class="v-list__label">
            {{ category.title }}
          </div>
        </router-link>
      </div>
      <a href="https://dtf.ru/games/details/subscriptions" class="v-list__more">
        Показать все
      </a>
    </div>
    <div v-else class="v-island__grayed">
      Пока что подписок нет =(
    </div>
  </div>
</template>

<script>
  export default {
    name: "UserCategoriesBlock",
    props: ['categories']
  }
</script>

<style scoped>

</style>
