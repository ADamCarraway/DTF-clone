<template>
  <div :class="['island__social_links__item',soc, {'island__social_links__item--active': provider.status}]"
       v-if="isActive(provider.name)"
       @click="syncProvider(provider.status ? 'detach' : 'attach', provider.name)">

    <ion-icon :name="icon"></ion-icon>
    <span class="island__social_links__title" style="text-transform: capitalize;">{{ provider.name }}</span>
    <div class="island__social_links__item__delete" v-if="provider.status">
      <ion-icon name="close-outline"></ion-icon>
    </div>
  </div>
</template>
<script>
  import axios from "axios";

  export default {
    name: "SocialButton",

    props: ['provider'],

    data() {
      return {
        soc: 'island__social_links__item--' + this.provider.name,
        icon: this.provider.icon,
        providers: []
      }
    },

    mounted() {
      this.providers = window.config.authProviders
    },

    methods: {
      isActive(provider){
        return window.config.authProviders.indexOf(provider)+1
      },
      syncProvider(type, provider) {
        switch (type) {
          case "attach":
            this.attach(provider)
            break;
          case "detach":
            this.detach(provider)
            break;
          default:
        }
      },
      detach(provider) {
        axios.post("/api/oauth/" + provider + "/detach").then(response => {
          this.provider.status = false
          this.$notify({
            message: 'Аккаунт успешно отвязан',
            type: 'success'
          });
        }).catch(error => {
          this.$notify({
            message: error.response.data.message,
            type: 'error',
          })
        })
      },
      async attach(provider) {

        const newWindow = socialWindow('', this.$t('login'))

        newWindow.location.href = await this.$store.dispatch('auth/fetchOauthUrl', {
          provider: provider
        })
      },
    },
  }
</script>

<style scoped>

</style>
