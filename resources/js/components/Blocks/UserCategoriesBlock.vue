<template>
  <div v-if="Object.keys(data).length !== 0" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">Подписки</span>
      <span class="v-island__counter"
            v-if="data.subscriptions_count">{{ data.subscriptions_count }}</span>
    </div>
    <div v-if="data.subscriptions_count" class="v-list v-list--default">
      <div class="v-list__content">
        <router-link v-for="item in data.subscriptions_limit"
                     :to="{ name: item.type, params: { slug: item.slug } }"
                     :key="item.slug" class="v-list__item">
          <div class="v-list__image" :style="{ backgroundImage: `url('${item.icon}')` }" lazy="loaded"></div>
          <div class="v-list__label">
            {{ item.title }}
          </div>
        </router-link>
      </div>
      <router-link :to="{ name: data.type+'.subscriptions' }" class="v-list__more">
        Показать все
      </router-link>
    </div>
    <div v-else class="v-island__grayed">
      У блога ещё нет подписок
    </div>
  </div>
  <user-categories-pre-block v-else></user-categories-pre-block>
</template>

<script>
  import UserCategoriesPreBlock from "../Preloaders/UserCategoriesPreBlock";

  export default {
    name: "UserCategoriesBlock",
    components: {UserCategoriesPreBlock},
    props: ['data'],
    computed: {}
  }
</script>

<style scoped>

</style>
