<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update">
      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
        <div class="col-md-7">
          <input v-model="name" class="form-control" type="text"
                 name="name">
        </div>
      </div>

      <!-- Email -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
        <div class="col-md-7">
          <input v-model="email" class="form-control"
                 type="email" name="email">
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
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
