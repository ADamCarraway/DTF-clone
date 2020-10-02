<template>
  <div v-if="users" class="l-island-bg l-island-round v-island">
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

      <router-link :to="to" class="v-list__more">
        Показать всех
      </router-link>
    </div>
    <div v-else class="v-island__grayed">
      Пока что подписчиков нет =(
    </div>
  </div>
</template>

<script>
  export default {
    name: "SubscribersBlock",
    props: ['users', 'count', 'type'],
    computed: {
      to: function () {
        return this.type === 'category' ? { name: 'subsite.subscribers' } : { name: 'user.subscribers' };
      },
    }
  }
</script>

<style scoped>

</style>
