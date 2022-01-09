<template>
  <div class="table__row l-island-a">
    <div class="table__cell">
      <router-link :to="{ name: data.type, params: {'slug': data.slug} }" target="_blank" class="subsite">
        <span class="subsite__rank">
          <small>{{index + 1}}</small> <!---->
        </span>
        <div class="subsite__avatar">
          <img :src="data.icon" lazy="loaded">
        </div>
        <div class="subsite__name"><strong>{{data.title}}</strong></div>
      </router-link>
    </div>
    <div class="table__cell">
      <small>
        <span>{{ data.rating ? data.rating : 1 }}</span>
      </small>
    </div>
    <div class="table__cell">
      <subscribe :data="data" :small="true"/>
    </div>
  </div>
</template>

<script>
  import Subscribe from "../Buttons/Subscribe";
  export default {
    name: "RatingTableItem",
    components: {Subscribe},
    props: ['data', 'index']
  }
</script>

<style scoped>

</style>
