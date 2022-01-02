<template>
  <div :class="{
        'u-notification u-notification--blue u-notification--border u-notification--hover': !isLenta,
    'u-notification u-notification--blue u-notification--bg': isLenta,
    'u-notification--unread': !item.read_at
  }">
    <router-link
      :to="{ name: item.data.post.category ? 'post' :'user.post', params: {postSlug: item.data.post.slug, slug: item.data.post.category ? item.data.post.category.slug : item.data.post.user.slug} }"
      class="u-notification__link"></router-link>
    <div class="u-notification__image u-notification__image--relative">
      <img class="andropov_image" style="background-color: transparent;"
           :src="item.data.post.category_id ? item.data.post.category.icon : item.data.post.user.avatar">
    </div>
    <div class="u-notification__content">
      <div class="u-notification__content__title" v-if="item.data.post.category_id">
        Опубликована запись
        <router-link
          :to="{ name: 'post', params: {postSlug: item.data.post.slug, slug: item.data.post.category.slug} }">
          <b>{{ item.data.post.short_title }}</b>
        </router-link>

        в
        <router-link :to="{ name: 'category', params: {name: item.type, params: {'slug': item.slug}} }">
          <b>{{ item.data.post.category.title }}</b>
        </router-link>

        <span class="u-notification__content__date">
          <time class="time">{{ item.data.post.date }}</time>
        </span>
      </div>
      <div class="u-notification__content__title" v-else>
        <router-link :to="{ name: 'user', params: {slug: item.data.post.user.slug} }">
          <b>{{ item.data.post.user.name }}</b>
        </router-link>
        опубликовал новую запись
        <router-link :to="{ name: 'user', params: {slug: item.data.post.user.slug} }">
          <b>{{ item.data.post.short_title }}</b>
        </router-link>
        <span class="u-notification__content__date">
          <time class="time">{{ item.data.post.date }}</time>
        </span>
      </div>
    </div>
    <div class="u-notification__controls">
    </div>
  </div>
</template>

<script>
export default {
  name: "NewPost",
  props: ['item', 'isLenta'],
  data() {

  }
}
</script>

<style scoped>

</style>
