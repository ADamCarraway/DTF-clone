<template>
  <div class="ui-tabs ui-tabs--default ui-border--top l-mb-15 l-island-bg">
    <div class="ui-tabs__scroll">
      <ul class="ui-tabs__content l-island-a">
        <li v-for="tab in tabs" :key="tab.route" class="ui-tab" :class="{'ui-tab--active': $route.name === tab.route}">
          <router-link :to="{ name: tab.route }" class="ui-tab__label">
            <span >{{ tab.name }}</span>
          </router-link>
          <span class="ui-tab__counter ">0</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  export default {
    name: "UserTabs",
    computed: {
      tabs() {
        return [
          {
            name: 'Статьи',
            route: 'home'
          },
          {
            name: 'Комментарии',
            route: 'user.comments'
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
