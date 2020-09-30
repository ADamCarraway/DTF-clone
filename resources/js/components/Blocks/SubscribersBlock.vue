<template>
  <div class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">Подписчики</span>
      <span class="v-island__counter">{{ count }}</span>
    </div>
    <div v-if="Object.keys(users).length > 0" class="v-list v-list--images">
      <div class="v-list__content">
        <router-link v-for="user in users" :to="{ name: 'home', params: {id: user.id} }" :key="user.id"
                     class="v-list__item">
          <div class="v-list__image" lazy="loaded" :style="{ backgroundImage: `url('${user.avatar}')` }"></div>
        </router-link>
      </div>

      <a href="https://dtf.ru/games/details/subscribers" class="v-list__more">
        Показать всех
      </a>
    </div>
    <div v-else class="v-island__grayed">
      Пока что подписчиков нет =(
    </div>
  </div>
</template>

<script>
  export default {
    name: "SubscribersBlock",
    props: ['users', 'count']
  }
</script>

<style scoped>

</style>
