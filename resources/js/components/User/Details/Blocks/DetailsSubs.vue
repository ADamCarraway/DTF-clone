<template>
  <div v-if="data" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      {{ title }}
    </span> <span class="v-island__counter">
      {{ data.total }}
    </span>
    </div>
    <div class="v-list-subsites">
      <div class="v-list-subsites__content v-list-subsites__content--columns-2">
        <div v-for="item in data.data" class="v-list-subsites-item">
          <router-link :to="{ name: routeName, params: {[key]: item[key]} }" :key="item.id"
                       class="v-list-subsites-item__main">
            <div class="v-list-subsites-item__image"
                 lazy="loaded"
                 :style="{ backgroundImage: `url('${item[avatar]}')` }"
            ></div>
            <div class="v-list-subsites-item__label">
              {{ item[name] }}
            </div>
          </router-link>
          <div v-if="type === 'users'"
               class="v-subscribe-button v-subscribe-button--short v-subscribe-button--state-inactive">
            <subscribe v-if="user && item.id !== user.id" :data="item" :type="'users'"></subscribe>
          </div>
          <div v-else class="v-subscribe-button v-subscribe-button--short v-subscribe-button--state-inactive">
            <subscribe :data="item" :type="'categories'"></subscribe>
          </div>
        </div>
      </div>
      <router-link :to="to" class="v-list__more">
        Показать всех
      </router-link>
    </div>
  </div>
</template>

<script>
  import Subscribe from "../../../Buttons/Subscribe";
  import {mapGetters} from "vuex";

  export default {
    name: "DetailsSubs",
    components: {Subscribe},
    props: ['data', 'type'],
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
      title: function () {
        return this.type === 'users' ? 'Подписчики' : 'Подписки';
      },
      routeName: function () {
        return this.type === 'users' ? 'user' : 'category';
      },
      key: function () {
        return this.type === 'users' ? 'id' : 'slug';
      },
      name: function () {
        return this.type === 'users' ? 'name' : 'title';
      },
      avatar: function () {
        return this.type === 'users' ? 'avatar' : 'icon';
      },
      to: function () {
        if (this.$route.name === 'user.details' && this.type === 'users') {
          return {name: 'user.subscribers'};
        } else if (this.$route.name === 'user.details' && this.type !== 'users') {
          return {name: 'user.subscriptions'};
        } else {
          return {name: 'category.subscribers'};
        }
      },
    },
  }
</script>

<style scoped>

</style>
