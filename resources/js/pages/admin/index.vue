<template>
  <h1>ADMIN PANEL</h1>
</template>

<script>
  import {mapGetters} from "vuex";

  export default {
    name: "index",
    middleware:['admin'],
    data() {
      return {
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
    },
    methods: {
    },
    metaInfo() {
      return {title: 'Админ панель'}
    }
  }
</script>

<style scoped>

</style>
