<template>
  <div class="social-auth__button" @click="login">
    <svg class="icon icon--ui_twitch" width="19" height="17">
      <fa :icon="['fab', 'twitch']" />
    </svg>
    <div class="social-auth__label">Twitch</div>
  </div>
</template>

<script>
  export default {
    name: 'LoginWithTwitch',

    computed: {
      twitchAuth: () => window.config.twitchAuth,
      url: () => `/api/oauth/twitch`
    },

    mounted () {
      window.addEventListener('message', this.onMessage, false)
    },

    beforeDestroy () {
      window.removeEventListener('message', this.onMessage)
    },

    methods: {
      async login () {
        const newWindow = openWindow('', this.$t('login'))

        const url = await this.$store.dispatch('auth/fetchOauthUrl', {
          provider: 'twitch'
        })

        newWindow.location.href = url
      },

      /**
       * @param {MessageEvent} e
       */
      onMessage (e) {
        if (e.origin !== window.origin || !e.data.token) {
          return
        }

        this.$store.dispatch('auth/saveToken', {
          token: e.data.token
        })

        this.$router.push({ name: 'home' })
      }
    }
  }

  /**
   * @param  {Object} options
   * @return {Window}
   */
  function openWindow (url, title, options = {}) {
    if (typeof url === 'object') {
      options = url
      url = ''
    }

    options = { url, title, width: 600, height: 720, ...options }

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
