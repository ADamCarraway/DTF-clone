<template>
  <div class="l-page__sidebar" style="position: relative;">
    <div class="l-island-bg l-island-round v-island"
         style="width: 300px; position: sticky; top: 140px;">
      <div class="v-island__header"><span class="v-island__title">
      Навигация
    </span>
      </div>
      <div class="v-list-tabs">
        <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route, params: tab.params }"
                     class="v-list-tab"
                     :class="{'v-list-tab--active': $route.name === tab.route}">
          <span class="v-list-tab__icon">
            <ion-icon :src="'/icons/'+tab.icon"></ion-icon>
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
    name: "DetailsSidebar",
    computed: {
      tabs() {
        return [
          {
            name: 'Обзор',
            route: 'category.details',
            icon: 'eye-outline.svg'
          },
          {
            name: 'Подписчики',
            route: 'category.subscribers',
            icon: 'people-outline.svg'
          },
          {
            name: 'Правила',
            route: 'category.rules',
            icon: 'alert-outline.svg'
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
