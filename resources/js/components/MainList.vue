<template>
  <div class="sidebar__tree-list">
    <div class="sidebar__tree-list__item"
         :class="{'sidebar-tree-list-item--active': $route.name === 'index' || $route.name === 'index.new'}">
      <router-link :to="{ name: 'index'}" @click.native="change('popular')"
                   class="sidebar-tree-list-item__link i_lenta">
        <span :class="{'icon--active': $route.name === 'index'}">
          <ion-icon src="/icons/flame-outline.svg"></ion-icon>
        </span>
        <p class="sidebar__tree-list__item__name">Лента</p>
      </router-link>
      <router-link :to="{ name: 'index.new'}" title="Свежее" class="sidebar-tree-list-item__child-item"
                   @click.native="change('new')">
        <!--        <i class="far fa-clock l-fs-22 mr-0"></i>-->
        <ion-icon src="/icons/time-outline.svg" :class="'mr-0'"></ion-icon>
      </router-link>
    </div>
    <router-link :to="{ name: 'rating'}" class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <ion-icon src="/icons/trending-up-outline.svg"></ion-icon>
        <p class="sidebar__tree-list__item__name">Рейтинг DTF</p>
      </div>
    </router-link>
    <router-link :to="{ name: 'subs'}" class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <ion-icon src="/icons/list-outline.svg"></ion-icon>
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
