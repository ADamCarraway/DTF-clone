import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import Echo from 'laravel-echo';

window.Vue = require('vue');

Vue.use(require('vue-resource'));
Vue.use(ElementUI);

import VueClipboard from 'vue-clipboard2'
Vue.config.ignoredElements = [/^ion-/]

VueClipboard.config.autoSetContainer = true // add this line
Vue.use(VueClipboard)

Vue.component('InfiniteLoading', require('vue-infinite-loading'));

window.Pusher = require('pusher-js');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  disableStats: true,
  forceTLS: false,
  wsHost: window.location.hostname,
  wsPort: 6001,
  wssPort: 6001,
  encrypted: true
});

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
