<template>
  <div :class="{
     'u-notification u-notification--blue u-notification--border u-notification--hover': !isLenta,
    'u-notification u-notification--green u-notification--bg': isLenta,
    'u-notification--unread': !item.read_at
  }">
    <router-link
      :to="{ name: item.data.comment.post.category ? 'post' :'user.post', params: {postSlug: item.data.comment.post.slug, slug: item.data.comment.post.category ? item.data.comment.post.category.slug : item.data.comment.post.user.slug} }"
      class="u-notification__link"></router-link>
    <div class="u-notification__image u-notification__image--relative">
      <img class="andropov_image" style="background-color: transparent;"
           :src="item.data.user.avatar">
      <div class="u-notification__avatar-icon" style="background: rgb(224, 36, 94)">
        <ion-icon name="heart" style="color: #fff"></ion-icon>
      </div>
    </div>
    <div class="u-notification__content">
      <div class="u-notification__content__title">
        <router-link :to="{ name: 'user', params: {slug: item.data.user.slug} }">
          <b>{{ item.data.user.name }}</b>
        </router-link>
        <br v-if="isLenta">
        оценил комментарий к записи
        <router-link
          :to="{ name: item.data.comment.post.category ? 'post' :'user.post', params: {postSlug: item.data.comment.post.slug, slug: item.data.comment.post.category ? item.data.comment.post.category.slug : item.data.comment.post.user.slug} }"
          class="u-notification__link">
          <b>{{item.data.comment.post.short_title}}</b>
        </router-link>
        <br v-if="isLenta">
        <span class="u-notification__content__date">
          <time class="time">{{ item.data.comment.date }}</time>
        </span>
      </div>
      <div class="u-notification__content__reply-text" :class="{'l-hidden': !show}">
        {{ item.data.comment.comment }}
      </div>
      <div class="u-notification__content__buttons" @click="show = !show" v-if="!isLenta">
        <div class="u-notification__content__button" v-if="!show">Развернуть</div>
        <div class="u-notification__content__button" v-else>Свернуть</div>
      </div>
    </div>
    <div class="u-notification__controls">
    </div>
  </div>
</template>

<script>
  import moment from 'moment';

  export default {
    name: "LikeComment",
    props: ['item', 'isLenta'],
    data(){
      return{
        'show': false
      }
    },
  }
</script>

<style scoped>

</style>
