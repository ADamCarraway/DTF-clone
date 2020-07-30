<template>
  <card title="Profile Photo">
    <div class="text-center">
      <img role="img" :style="{'background-image': 'url('+avatar+')'}" class="profile-photo-preview text-center mb-3">
    </div>
    <!-- Avatar -->
    <div class="form-group row">
      <div class="col-md-12 text-center">
        <input type="file" v-on:change="update" class="">
      </div>
    </div>
  </card>
</template>

<script>
  import axios from 'axios'
  import {mapGetters} from 'vuex'

  export default {
    name: "AvatarSetting",

    data() {
      return {
        avatar: ''
      }
    },

    computed: mapGetters({
      user: 'auth/user'
    }),

    created() {
      this.avatar = this.user['avatar']
    },

    methods: {
      update(e) {
        const data = new FormData();
        data.append('avatar', e.target.files[0]);

        let vm = this;
        axios.post('/api/settings/profile/avatar/update', data)
          .then(function (response) {
            vm.avatar = response.data.avatar
            vm.$store.dispatch('auth/updateUser', {user: {'avatar': response.data.avatar}})
          })
      },
    }
  }
</script>
