<template>
  <div class="u-notification u-notification--blue u-notification--border u-notification--hover" :class="{'u-notification--unread': !item.read_at}">
    <router-link :to="{ name: 'user', params: {slug: item.data.user.slug} }" class="u-notification__link"></router-link>
    <div class="u-notification__image u-notification__image--relative">
      <img class="andropov_image" style="background-color: transparent;"
           :src="item.data.user.avatar">
      <div class="u-notification__avatar-icon">
        <ion-icon name="checkmark-outline" style="color: #fff"></ion-icon>
      </div>
    </div>
    <div class="u-notification__content">
      <div class="u-notification__content__title">
        <router-link :to="{ name: 'user', params: {slug: item.data.user.slug} }">
          <b>{{ item.data.user.name }}</b>
        </router-link>
        подписался на ваш блог &nbsp;
        <span class="u-notification__content__date">
            <time class="time">{{ item.data.date }}</time>
        </span>
      </div>
      <div class="u-notification__content__buttons">
      </div>
    </div>
    <div class="u-notification__controls">
    </div>
  </div>
</template>

<script>
  export default {
    name: "NewFollow",
    props: ['item']
  }
</script>

<style scoped>

</style>
