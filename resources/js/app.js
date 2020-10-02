import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import AtComponents from 'at-ui'
Vue.use(AtComponents)

window.Vue = require('vue');

Vue.use(require('vue-resource'));

Vue.component('InfiniteLoading', require('vue-infinite-loading'));

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
