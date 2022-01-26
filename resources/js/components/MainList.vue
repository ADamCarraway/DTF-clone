<template>
  <div class="sidebar__tree-list">
    <div v-if="$route.name && ($route.name).indexOf('admin')+1 !== 1">
      <router-link :to="{ name: 'index'}" @click.native="change('popular')"
                   class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="flame-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Популярное</p>
        </div>
      </router-link>
      <router-link :to="{ name: 'index.new'}" class="sidebar__tree-list__item" @click.native="change('new')">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="time-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Севежее</p>
          <p class="sidebar-tree-list-item__badge" v-if="newCount">{{ newCount }}</p>
        </div>
      </router-link>
      <router-link :to="{ name: 'user.favorites', params:{'slug': user.slug}}" class="sidebar__tree-list__item"
                   v-if="user">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="bookmark-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Закладки</p>
        </div>
      </router-link>
      <router-link :to="{ name: 'rating'}" class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="trending-up-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Рейтинг</p>
        </div>
      </router-link>
      <router-link :to="{ name: 'subs'}" class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="list-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Подписки</p>
        </div>
      </router-link>
      <router-link :to="{ name: 'admin.index'}"
                   v-if="user && user.is_admin"
                   class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="grid-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Админ панель</p>
        </div>
      </router-link>
    </div>
    <div v-else>
      <router-link :to="{ name: 'admin.index'}"
                   v-if="user && user.is_admin"
                   class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="grid-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Админ панель</p>
        </div>
      </router-link>

      <router-link :to="{ name: 'admin.users.index'}"
                   v-if="user && user.is_admin && user.all_permissions.includes('view all users')"
                   class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="people-outline" class="sidebar__icon"></ion-icon>
          <p class="sidebar__tree-list__item__name">Пользователи</p>
        </div>
      </router-link>

      <router-link :to="{ name: 'admin.roles.index'}"
                   v-if="user && user.is_admin && user.all_permissions.includes('view all roles')"
                   class="sidebar__tree-list__item">
        <div class="sidebar-tree-list-item__link">
          <ion-icon name="list-outline"></ion-icon>
          <p class="sidebar__tree-list__item__name">Роли</p>
        </div>
      </router-link>

    </div>
  </div>
</template>

<script>

import EventBus from "../plugins/event-bus";
import {mapGetters} from "vuex";

export default {
  name: "MainList",
  data: function () {
    return {
      newCount: 0
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
  mounted() {
    EventBus.$on('clearNewPosts', () => {
      this.newCount = 0;
    });

    let subs = this.user ? this.user.subscriptions : window.config.categories;

    for (const [key, value] of Object.entries(subs)) {
      Echo.channel('new-post-counter.' + value.id).notification(notification => {
        this.newCount += 1;
      });
    }
  },
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

.router-link-exact-active ion-icon {
  color: #3793e5;
}

</style>
