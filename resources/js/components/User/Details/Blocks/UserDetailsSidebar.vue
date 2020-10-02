<template>
  <div data-v-b1807cea="" class="l-page__sidebar" style="position: relative;">
    <div data-v-b1807cea="" class="l-island-bg l-island-round v-island"
         style="width: 300px; position: sticky; top: 80px;">
      <div class="v-island__header"><span class="v-island__title">
      Навигация
    </span>
      </div>
      <div class="v-list-tabs">
        <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route, params: tab.params }"
                     class="v-list-tab"
                     :class="{'v-list-tab--active': $route.name === tab.route}">
          <span class="v-list-tab__icon">
            <i :class="['fas '+tab.icon]"></i>
          </span>
          <span class="v-list-tab__label">
            <span>{{ tab.name}}</span>
          </span>
        </router-link>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "UserDetailsSidebar",
    computed: {
      tabs() {
        return [
          {
            name: 'Обзор',
            route: 'user.details',
            icon: 'fa-eye'
          },
          {
            name: 'Подписчики',
            route: 'user.subscribers',
            icon: 'fa-user-friends'
          },
          {
            name: 'Подписки',
            route: 'user.subscriptions',
            icon: 'fa-star'
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
