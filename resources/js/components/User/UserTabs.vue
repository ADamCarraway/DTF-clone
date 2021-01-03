<template>
  <div class="v-header__tabs">
    <div class="v-tabs">
      <div class="v-tabs__scroll">
        <div class="v-tabs__content">
          <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route }"
                       class="v-tab"
                       :class="{'v-tab--active': tab.active.includes($route.name)}"
                        v-if="tab.if">
                      <span class="v-tab__label">{{ tab.name }}
                        <span class="v-tab__counter">{{ tab.count}}</span>
                    </span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import store from '~/store'

  export default {
    name: "UserTabs",
    props: ['user'],
    computed: {
      tabs() {
        return [
          {
            name: 'Статьи',
            route: 'user',
            active: ['user', 'user.new'],
            count: this.user ? this.user.posts_count : 0,
            if: true
          },
          {
            name: 'Комментарии',
            route: 'user.comments',
            active: ['user.comments', 'user.comments.new'],
            count: this.user ? this.user.comments_count : 0,
            if: true
          },
          {
            name: 'Закладки',
            route: 'user.favorites',
            active: ['user.favorites', 'user.favorites.comments'],
            count: this.user ? this.user.bookmarks_count : 0,
            if: this.user ? store.getters['auth/user'].slug === this.user.slug : false
          },
          {
            name: 'Подробнее',
            route: 'user.details',
            active: ['user.details', 'user.subscribers', 'user.subscriptions'],
            if: true
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
