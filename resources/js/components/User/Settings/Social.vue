<template>
  <card title="Social" v-if="link">
    <div class="island__social_links">
      <social-button v-for="i in oauth_providers" :provider="i" :key="i.name"/>
    </div>
  </card>
</template>

<script>
  import {mapGetters} from 'vuex'
  import SocialButton from "./SocialButton";

  export default {
    name: "Social",
    components: {SocialButton},

    data() {
      return {
        arr: {
          'twitter': {name: 'twitter', status: false},
          'facebook': {name: 'facebook', status: false},
          'google': {name: 'google', status: false},
          'twitch': {name: 'twitch', status: false}
        }
      }
    },
    mounted() {
      window.addEventListener('message', this.onMessage, false)
    },

    beforeDestroy() {
      window.removeEventListener('message', this.onMessage)
    },

    computed: {
      ...mapGetters({
        link: 'auth/user'
      }),

      oauth_providers() {
        let oauth_providers = this.arr;

        Object.values(this.link.oauth_providers).forEach(value => {
          if (Object.keys(oauth_providers).includes(value.provider)) oauth_providers[value.provider].status = true
        })

        return oauth_providers;
      }
    },

    methods: {
      onMessage(e) {
        if (e.origin !== window.origin || !e.data.status) {
          return
        }

        if (e.data.status === 'false') {
          this.$Notify.error({
            message: e.data.message
          })
          return
        }

        this.oauth_providers[e.data.provider].status = e.data.status;
        this.$Notify.success({
          title: 'Успех!',
          message: 'Аккаунт успешно привязан',
          showClose: false
        })
      }
    }
  }

  window.socialWindow = function openWindow(url, title, options = {}) {
    if (typeof url === 'object') {
      options = url
      url = ''
    }

    options = {url, title, width: 600, height: 720, ...options}

    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
    const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
    const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

    options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
    options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

    const optionsStr = Object.keys(options).reduce((acc, key) => {
      acc.push(`${key}=${options[key]}`)
      return acc
    }, []).join(',')

    const newWindow = window.open(url, title, optionsStr)

    if (window.focus) {
      newWindow.focus()
    }

    return newWindow
  }
</script>

<style scoped>

</style>
