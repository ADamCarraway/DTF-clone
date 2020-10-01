<template>
  <div v-if="data" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      Подписчики
    </span> <span class="v-island__counter">
      {{ data.total }}
    </span>
    </div>
    <div class="v-list-subsites">
      <div class="v-list-subsites__content v-list-subsites__content--columns-2">
        <div v-for="user in data.data" class="v-list-subsites-item">
          <router-link :to="{ name: 'home', params: {id: user.id} }" :key="user.id"
                       class="v-list-subsites-item__main">
            <div class="v-list-subsites-item__image"
                 lazy="loaded"
                 :style="{ backgroundImage: `url('${user.avatar}')` }"
            ></div>
            <div class="v-list-subsites-item__label">
              {{ user.name }}
            </div>
          </router-link>
          <div class="v-subscribe-button v-subscribe-button--short v-subscribe-button--state-inactive">
            <subscribe v-if="user && data.id !== user.id" :data="data" :type="'users'"></subscribe>
          </div>
        </div>
      </div>
      <router-link :to="{ name: 'subsite.subscribers' }" class="v-list-subsites__more">
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
    props: ['data'],
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
    },
  }
</script>

<style scoped>

</style>
