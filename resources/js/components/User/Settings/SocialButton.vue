<template>
  <div :class="['island__social_links__item',soc, {'island__social_links__item--active': provider.status}]">
    <i :class="['fab' , icon]"></i>
    <span class="island__social_links__title">{{ provider.name }}</span>
    <div class="island__social_links__item__delete" v-if="provider.status" @click="detach(provider.name)">
      <i class="icon icon-x"></i>
    </div>
    <div class="island__social_links__item__delete" v-else @click="attach(provider.name)">
      <i class="icon icon-plus"></i>
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
        icon: 'fa-' + this.provider.name
      }
    },

    methods: {
      detach(provider) {
        axios.post("/api/oauth/" + provider + "/detach").then(response => {
          this.provider.status = false

          this.$Notify.success({
            title: 'Успех!',
            message: 'Аккаунт успешно отвязан'
          })
        }).catch(error => {
          this.$Notify({
            title: 'Ошибка!',
            message: error.response.data.message,
            type: 'error',
            showClose: false
          })
        })
      },
      async  attach(provider) {

        const newWindow = socialWindow('', this.$t('login'))

        const url = await this.$store.dispatch('auth/fetchOauthUrl', {
          provider: provider
        })

        newWindow.location.href = url
      },
    },
  }
</script>

<style scoped>

</style>
