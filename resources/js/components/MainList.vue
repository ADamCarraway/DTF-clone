<template>
    <div class="sidebar__tree-list">
      <router-link :to="{ name: 'index'}" class="sidebar__tree-list__item i_lenta">
            <div class="sidebar-tree-list-item__link">
                <i class="fas fa-fire-alt"></i>
                <p class="sidebar__tree-list__item__name">Лента</p>
            </div>
            <router-link :to="{ name: 'index.new'}" title="Свежее" class="sidebar-tree-list-item__child-item">
                <i class="far fa-clock mr-0"></i>
            </router-link>
        </router-link>
        <router-link :to="{ name: 'subs'}" class="sidebar__tree-list__item">
            <div class="sidebar-tree-list-item__link">
                <i class="fas fa-list-ul"></i>
                <p class="sidebar__tree-list__item__name">Подписки</p>
            </div>
        </router-link>
    </div>
</template>

<script>

    export default {
        name: "MainList",
    }
</script>

<style scoped>
  .router-link-exact-active {
    background: #fff;
  }

</style>
