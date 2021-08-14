<template>
  <div>
    <transition name="fade" mode="out-in">
      <router-view/>
    </transition>
  </div>
</template>

<script>
    export default {
        name: "index"
    }
</script>

<style scoped>

</style>
