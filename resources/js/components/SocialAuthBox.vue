<template>
  <div class="auth-form__tab auth_tab auth_tab--signin-start">

    <div class="auth-form__content">
      <div class="auth-form__title l-mb-20">Вход на DTF</div>

      <div class="social-auth__button" @click="login('google')">
        <i class="fab fa-google l-fs-24"></i>
        <div class="social-auth__label">Google</div>
      </div>

      <div class="social-auth__button" @click="login('vk')">
        <i class="fab fa-vk l-fs-24"></i>
        <div class="social-auth__label">ВКонтакте</div>
      </div>

      <!-- Login Form Button -->
      <div class="social-auth__button" @click="showLoginForm()">
        <i class="far fa-envelope l-fs-24"></i>
        <div class="social-auth__label">Через почту</div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="social-auth__button" @click="login('twitter')">
            <i class="fab fa-twitch l-fs-24"></i>
          </div>
        </div>
        <div class="col-md-4">
          <div class="social-auth__button" @click="login('twitch')">
            <i class="fab fa-twitter l-fs-24"></i>
          </div>
        </div>
        <div class="col-md-4">
          <div class="social-auth__button" @click="login('facebook')">
            <i class="fab fa-facebook-f l-fs-24"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import EventBus from '../plugins/event-bus';

  export default {
    name: 'SocialAuthBox',
    props: [''],
    data() {
      return {
        url: ''
      }
    },

    mounted() {
      window.addEventListener('message', this.onMessage, false)
    },

    beforeDestroy() {
      window.removeEventListener('message', this.onMessage)
    },

    methods: {
      async login(provider) {
        this.url = `/api/oauth/` + provider;

        const newWindow = openWindow('', this.$t('login'))

        const url = await this.$store.dispatch('auth/fetchOauthUrl', {
          provider: provider
        })

        newWindow.location.href = url
      },

      /**
       * @param {MessageEvent} e
       */
      onMessage(e) {
        if (e.origin !== window.origin || !e.data.token) {
          return
        }

        this.$store.dispatch('auth/saveToken', {
          token: e.data.token
        })

        EventBus.$emit('loginModal', false);

        // this.$router.push({ name: this.$route.name })
        location.reload()
      },

      showLoginForm() {
        EventBus.$emit('show', 'login-form');
      }
    }
  }

  /**
   * @param  {Object} options
   * @return {Window}
   */
  function openWindow(url, title, options = {}) {
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
