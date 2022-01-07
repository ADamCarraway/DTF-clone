<template>
  <div class="auth-form__tab auth_tab auth_tab--signin-start">

    <div v-if="!isNotification" class="auth-form__content">
      <div class="auth-form__title l-mb-20">Вход в аккаунт</div>

      <!-- Login Form Button -->
      <div class="social-auth__button" @click="showLoginForm()">
        <ion-icon name="mail-outline"></ion-icon>
        <div class="social-auth__label">Почта</div>
      </div>

      <div class="social-auth__button" @click="login('vk')">
        <ion-icon name="logo-vk"></ion-icon>
        <div class="social-auth__label">ВКонтакте</div>
      </div>

      <div class="social-auth__button" @click="login('google')">
        <ion-icon name="logo-google"></ion-icon>
        <div class="social-auth__label">Google</div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="social-auth__button" @click="login('twitter')">
            <ion-icon name="logo-twitter"></ion-icon>
          </div>
        </div>
        <div class="col-md-4">
          <div class="social-auth__button" @click="login('twitch')">
            <ion-icon name="logo-twitch"></ion-icon>
          </div>
        </div>
        <div class="col-md-4">
          <div class="social-auth__button" @click="login('facebook')">
            <ion-icon name="logo-facebook"></ion-icon>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-start" style="font-size: 16px">
        <span class="mr-2">Нет аккаунта? </span>
        <div data-gtm="Signup — Login — Click" class="t-link-inline" @click="show('register-form')">
          Регистрация
        </div>
      </div>

    </div>

    <div v-else>
      <div class="l-flex l-mt-9 l-mb-10">

        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--ifb l-mr-10"
             @click="login('facebook')">
          <ion-icon name="logo-facebook"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--ivk l-mr-10"
             @click="login('vk')">
          <ion-icon name="logo-vk"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--igg l-mr-10"
             @click="login('google')">
          <ion-icon name="logo-google"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--igg l-mr-10"
             @click="login('twitch')">
          <ion-icon name="logo-twitch"></ion-icon>
        </div>
        <!--          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;itw l-mr-10">-->
        <!--            <svg class="icon icon&#45;&#45;ui_twitter" width="15" height="12"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_twitter"></use></svg>-->
        <!--          </div>-->
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--iemail l-mr-10"
         @click="showLoginModal">
          <ion-icon name="mail-outline"></ion-icon>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import EventBus from '../plugins/event-bus';

export default {
  name: 'SocialAuthBox',
  props: ['isNotification'],
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
    show(name) {
      EventBus.$emit('show', name);
    },
    showLoginModal(){
      EventBus.$emit('loginModal', true);
    },
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
