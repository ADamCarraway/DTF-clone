<template>
  <div>
    <transition name="fade" mode="out-in">
      <router-view/>
    </transition>
  </div>
</template>

<script>
  import AllDetails from "../../../components/User/Details/AllDetails";
  import DetailsSidebar from "../../../components/User/Details/Blocks/DetailsSidebar";
  export default {
    name: "index",
    components: {DetailsSidebar, AllDetails}
  }
</script>

<style scoped>

</style>
