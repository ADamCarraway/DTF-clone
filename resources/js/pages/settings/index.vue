<template>
  <div>
    <profile />
    <br>
    <password />
  </div>
</template>

<script>
  import Password from "./password";
  import Profile from "./profile";
  export default {
    components: {Profile, Password},
    middleware: 'auth',

    computed: {
      tabs() {
        return [
          {
            icon: 'user',
            name: this.$t('profile'),
            route: 'settings.profile'
          },
          {
            icon: 'lock',
            name: this.$t('password'),
            route: 'settings.password'
          }
        ]
      }
    }
  }
</script>

<style>
  .settings-card .card-body {
    padding: 0;
  }
</style>
