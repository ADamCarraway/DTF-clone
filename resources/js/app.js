import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

window.Vue = require('vue');

Vue.use(require('vue-resource'));
Vue.use(ElementUI);

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
