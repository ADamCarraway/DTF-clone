<template>
  <div class="v-header__tabs">
    <div class="v-tabs">
      <div class="v-tabs__scroll">
        <div class="v-tabs__content">
          <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route, params: tab.params }"
                       class="v-tab"
                       :class="{'v-tab--active': tab.active.includes($route.name)}">
            <span class="v-tab__label">{{ tab.name }}
              <!--              <span class="v-tab__counter">16 038</span>-->
            </span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "CategoryTabs",
    props: ['data'],
    computed: {
      tabs() {
        return [
          {
            name: 'Статьи',
            route: 'category',
            active: ['category', 'user']
          },
          {
            name: 'Подробнее',
            route: 'category.details',
            active: [
              'category.details', 'category.subscribers', 'category.rules',
              'user.details', 'user.subscribers', 'user.subscriptions'
            ]
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
