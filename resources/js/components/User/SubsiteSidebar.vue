<template>
  <div class="l-page__sidebar lm-hidden" style="position: relative;">
    <div class="subsite-sidebar" style="width: 300px;">
      <subscribers-block :users="data[key]" :count="data[key+'_count']" :type="type"></subscribers-block>
      <user-categories-block v-if="type === 'user'" :categories="data.categories" :type="type"></user-categories-block>
      <regulations-box v-if="data.regulations" :data="data.regulations"></regulations-box>
    </div>
  </div>
</template>

<script>
  import SubscribersBlock from "../Blocks/SubscribersBlock";
  import UserCategoriesBlock from "../Blocks/UserCategoriesBlock";
  import RegulationsBox from "../Blocks/RegulationsBox";

  export default {
    name: "SubsiteSidebar",
    props: ['data', 'type'],
    components: {
      RegulationsBox,
      UserCategoriesBlock, SubscribersBlock
    },
    computed: {
      key: function () {
        return this.type === 'user' ? 'subscribers' : 'users';
      },
    }
  }
</script>

<style scoped>

</style>
