<template>
  <div class="sidebar__tree-list">
    <router-link :to="{ name: 'index'}" @click.native="change('popular')"
                 class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <ion-icon src="/icons/flame-outline.svg"  class="sidebar__icon"></ion-icon>
        <p class="sidebar__tree-list__item__name">Лента</p>
      </div>
    </router-link>
    <router-link :to="{ name: 'index.new'}" class="sidebar__tree-list__item" @click.native="change('new')">
      <div class="sidebar-tree-list-item__link">
        <ion-icon src="/icons/time-outline.svg" class="sidebar__icon"></ion-icon>
        <p class="sidebar__tree-list__item__name">Севежее</p>
      </div>
    </router-link>
    <router-link :to="{ name: 'rating'}" class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <ion-icon src="/icons/trending-up-outline.svg" class="sidebar__icon"></ion-icon>
        <p class="sidebar__tree-list__item__name">Рейтинг DTF</p>
      </div>
    </router-link>
    <router-link :to="{ name: 'subs'}" class="sidebar__tree-list__item">
      <div class="sidebar-tree-list-item__link">
        <ion-icon src="/icons/list-outline.svg" class="sidebar__icon"></ion-icon>
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
.router-link-exact-active ion-icon{
  color: #3793e5;
}

</style>
