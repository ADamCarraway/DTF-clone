<template>
  <div class="l-page__sidebar lm-hidden" style="position: relative;">
    <div class="subsite-sidebar" style="width: 300px; position: sticky; top: 140px;">
      <subscribers-block :data="data"></subscribers-block>
      <user-categories-block v-if="data.type === 'user'" :data="data"></user-categories-block>
      <regulations-box v-if="data.regulations && data.type === 'category'" :data="data.regulations"></regulations-box>
    </div>
  </div>
</template>

<script>
  import SubscribersBlock from "../Blocks/SubscribersBlock";
  import UserCategoriesBlock from "../Blocks/UserCategoriesBlock";
  import RegulationsBox from "../Blocks/RegulationsBox";

  export default {
    name: "SubsiteSidebar",
    props: ['data'],
    components: {
      RegulationsBox,
      UserCategoriesBlock, SubscribersBlock
    },
  }
</script>

<style scoped>

</style>
