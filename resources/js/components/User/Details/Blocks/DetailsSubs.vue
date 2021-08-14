<template>
  <div v-if="Object.keys(data).length !== 0" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      {{ title }}
    </span> <span class="v-island__counter" v-if="data.total > 0">
      {{ data.total }}
    </span>
    </div>
    <div class="v-list-subsites" v-if="Object.keys(data).length > 0">
      <div class="v-list-subsites__content v-list-subsites__content--columns-2">
        <div v-for="item in data" class="v-list-subsites-item">
          <router-link :to="{ name: item.type, params: {slug: item.slug} }" :key="item.slug"
                       class="v-list-subsites-item__main">
            <div class="v-list-subsites-item__image"
                 lazy="loaded"
                 :style="{ backgroundImage: `url('${item.icon}')` }">
            </div>
            <div class="v-list-subsites-item__label">
              {{ item.title }}
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
    <div v-else >
      <div class="v-island__grayed">
        У блога ещё нет {{ noResultTitle }}
      </div>
    </div>
  </div>
  <details-sub-pre-block v-else></details-sub-pre-block>
</template>

<script>
  import Subscribe from "../../../Buttons/Subscribe";
  import {mapGetters} from "vuex";
  import DetailsSubPreBlock from "../../../Preloaders/DetailsSubPreBlock";

  export default {
    name: "DetailsSubs",
    components: {DetailsSubPreBlock, Subscribe},
    props: ['data', 'type'],
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
      title: function () {
        return this.type === 'users' ? 'Подписчики' : 'Подписки';
      },

      noResultTitle: function () {
        return this.type === 'users' ? 'подписчиков' : 'подписок';
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
