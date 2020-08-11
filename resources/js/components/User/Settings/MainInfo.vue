<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update">
      <!-- Name -->
      <div class="row at-row">
        <div class="col-md-24 mb-2">
          <input v-model="name" class="form-control" type="text"
                 name="name">
        </div>
      </div>

      <!-- Email -->
      <div class="row at-row">
        <div class="col-md-24 mb-2">
          <input v-model="email" class="form-control"
                 type="email" name="email">
        </div>
      </div>

      <!-- Submit Button -->
      <div class="row at-row">
        <div class="col-md-24 ml-md-auto">
          <v-button type="success">
            {{ $t('update') }}
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
  import axios from 'axios'
  import {mapGetters} from 'vuex'

  export default {
    name: "MainInfo",

    scrollToTop: false,

    metaInfo() {
      return {title: this.$t('settings')}
    },

    data() {
      return {
        name: '',
        email: '',
      }
    },

    computed: mapGetters({
      user: 'auth/user'
    }),

    created() {
      this.name = this.user['name']
      this.email = this.user['email']
    },

    methods: {
      update() {
        let data = {
          'name': this.name,
          'email': this.email,
        }

        axios.post('/api/settings/profile', data).then(function (response) {

        })

        this.$store.dispatch('auth/updateUser', {user: data})
      },
    }
  }
</script>

<style scoped>

</style>
