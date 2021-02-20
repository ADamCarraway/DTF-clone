<template>
  <div class="sidebar__tree-list">
    <div class="sidebar__tree-list__item" :class="{'sidebar-tree-list-item--active': $route.name === 'index' || $route.name === 'index.new'}">
      <router-link :to="{ name: 'index'}"  @click.native="change('popular')" class="sidebar-tree-list-item__link i_lenta">
        <i class="fas fa-fire-alt l-fs-27" :class="{'icon--active': $route.name === 'index'}"></i>
        <p class="sidebar__tree-list__item__name">Лента</p>
      </router-link>
      <router-link :to="{ name: 'index.new'}" title="Свежее" class="sidebar-tree-list-item__child-item"
                   @click.native="change('new')">
        <i class="far fa-clock l-fs-22 mr-0"></i>
      </router-link>
    </div>
    <router-link :to="{ name: 'rating'}" class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <i class="far fa-star l-fs-27"></i>
        <p class="sidebar__tree-list__item__name">Рейтинг DTF</p>
      </div>
    </router-link>
    <router-link :to="{ name: 'subs'}" class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <i class="fas fa-list-ul l-fs-27"></i>
        <p class="sidebar__tree-list__item__name">Подписки</p>
      </div>
    </router-link>
  </div>
</template>

<script>

  import EventBus from "../plugins/event-bus";

  export default {
    name: "MainList",
    methods: {
      change(filter) {
        EventBus.$emit('changePostsRoute', filter)
      }
    }
  }
</script>

<style scoped>
  .router-link-exact-active {
    background: #fff;
  }

</style>
