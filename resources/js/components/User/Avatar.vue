<template>
  <div class="v-header__avatar v-header-avatar" :class="{'preloader': !data || preloader}"
       :style="{ backgroundImage: `url('${data.avatar}')` }">
    <label for="avatar-upload" class="avatar-upload-icon" v-if="(data.slug && user && user.slug == $route.params.slug) && !preloader">
      <ion-icon name="image-outline"></ion-icon>
      <input type="file" v-on:change="update" class="" id="avatar-upload" style="display: none">
    </label>
  </div>
</template>

<script>
  import axios from 'axios'
  import {mapGetters} from 'vuex'

  export default {
    name: "Avatar",
    props: ['data'],
    data(){
      return{
        'preloader': false
      }
    },
    computed: mapGetters({
      user: 'auth/user'
    }),

    methods: {
      update(e) {
        this.preloader = true;
        const data = new FormData();
        data.append('avatar', e.target.files[0]);

        axios.post('/api/settings/profile/avatar/update', data)
          .then((response) => {
            this.preloader = false;
            // this.data = response.data.avatar;
            this.$store.dispatch('auth/updateUser', {user: {'avatar': response.data.avatar}})
          })
      },
    }
  }
</script>
