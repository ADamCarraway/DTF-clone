<template>
  <div class="auth-form__tab auth_tab auth_tab--signin-start">

    <div v-if="!isNotification" class="auth-form__content">
      <div class="auth-form__title l-mb-20">Вход в аккаунт</div>

      <!-- Login Form Button -->
      <div class="social-auth__button" @click="showLoginForm()">
        <ion-icon name="mail-outline" class="ui-button--iemail micon"></ion-icon>
        <div class="social-auth__label">Почта</div>
      </div>

      <div class="social-auth__button" @click="login('vkontakte')" v-if="isActive('vkontakte')">
        <ion-icon name="logo-vk" class="ui-button--ivk micon"></ion-icon>
        <div class="social-auth__label">ВКонтакте</div>
      </div>

      <div class="social-auth__button" @click="login('google')" v-if="isActive('google')">
        <ion-icon name="logo-google" class="ui-button--igg micon"></ion-icon>
        <div class="social-auth__label">Google</div>
      </div>

      <div class="row">
        <div class="col-4 col-sm-4">
          <div class="social-auth__button" @click="login('facebook')" v-if="isActive('facebook')">
            <ion-icon name="logo-facebook" class="ui-button--ifb"></ion-icon>
          </div>
        </div>
        <div class="col-4 col-sm-4">
          <div class="social-auth__button" @click="login('twitter')" v-if="isActive('twitter')">
            <ion-icon name="logo-twitter" class="ui-button--itw"></ion-icon>
          </div>
        </div>
        <div class="col-4 col-sm-4">
          <div class="social-auth__button" @click="login('twitch')" v-if="isActive('twitch')">
            <ion-icon name="logo-twitch" class="ui-button--ittv"></ion-icon>
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
             v-if="isActive('facebook')"
             @click="login('facebook')">
          <ion-icon name="logo-facebook"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--ivk l-mr-10"
             v-if="isActive('vkontakte')"
             @click="login('vkontakte')">
          <ion-icon name="logo-vk"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--igg l-mr-10"
             v-if="isActive('google')"
             @click="login('google')">
          <ion-icon name="logo-google"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--itw l-mr-10"
             v-if="isActive('twitter')"
             @click="login('twitter')">
          <ion-icon name="logo-twitter"></ion-icon>
        </div>
        <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--ittv l-mr-10"
             v-if="isActive('twitch')"
             @click="login('twitch')">
          <ion-icon name="logo-twitch"></ion-icon>
        </div>
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
      url: '',
      providers: []
    }
  },

  mounted() {
    window.addEventListener('message', this.onMessage, false)

    this.providers = window.config.authProviders
  },

  beforeDestroy() {
    window.removeEventListener('message', this.onMessage)
  },

  methods: {
    isActive(provider){
      return window.config.authProviders.indexOf(provider)+1
    },
    show(name) {
      EventBus.$emit('show', name);
    },
    showLoginModal() {
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

<style scoped>
.micon {
  margin-left: 6px;
  margin-right: -6px;
}
</style>