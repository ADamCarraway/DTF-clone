<template>
  <card title="Social" v-if="link">
    <div v-for="i in link.oauth_providers">
      {{ i.provider }}
    </div>
  </card>
</template>

<script>
  import axios from 'axios'
  import {mapGetters} from 'vuex'

  export default {
    name: "Social",
    data(){
      return {
      }
    },

    computed: mapGetters({
      link: 'auth/user'
    }),
  }
</script>

<style scoped>

</style>
