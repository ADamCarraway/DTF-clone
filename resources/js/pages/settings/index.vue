<template>
  <div>
    <profile/>
    <br>
    <password v-if="user.password"/>
  </div>
</template>

<script>
  import Password from "./password";
  import Profile from "./profile";
  import {mapGetters} from "vuex";

  export default {
    components: {Profile, Password},
    middleware: 'auth',

    computed: {
      ...mapGetters({
        user: 'auth/user'
      }),
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
    },

    mounted() {

    }
  }
</script>

<style>
  .settings-card .card-body {
    padding: 0;
  }
</style>
