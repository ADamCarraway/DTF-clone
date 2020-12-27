<template>
  <div v-if="Object.keys(data).length !== 0" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">Подписчики</span>
      <span class="v-island__counter" v-if="data.subscribers_count">{{ data.subscribers_count }}</span>
    </div>

    <div v-if="data.subscribers_count > 0" class="v-list v-list--images">
      <div class="v-list__content">
        <router-link v-for="item in data.subscribers" :to="{ name: item.type, params: {slug: item.slug} }" :key="item.slug"
                     class="v-list__item">
          <div class="v-list__image" lazy="loaded" :style="{ backgroundImage: `url('${item.avatar}')` }"></div>
        </router-link>
      </div>

      <router-link :to="{ name: data.type+'.subscribers' }" class="v-list__more">
        Показать всех
      </router-link>
    </div>
    <div v-else class="v-island__grayed">
      У блога ещё нет подписчиков
    </div>
  </div>
  <subscribers-pre-block v-else></subscribers-pre-block>
</template>

<script>
  import SubscribersPreBlock from "../Preloaders/SubscribersPreBlock";
  export default {
    name: "SubscribersBlock",
    components: {SubscribersPreBlock},
    props: ['data'],
    computed: {
    }
  }
</script>

<style scoped>

</style>
