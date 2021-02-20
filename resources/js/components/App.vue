<template>
  <div id="app">
    <loading ref="loading" />

    <transition name="page" mode="out-in">
      <component :is="layout" v-if="layout" />
    </transition>

    <el-dialog
      :visible.sync="loginModal"
      :show-close="false"
      :custom-class="'loginBox'">
      <span slot="title"></span>
      <login-box/>
      <span slot="footer"></span>
    </el-dialog>

  </div>
</template>

<script>
import Loading from './Loading'
import EventBus from "../plugins/event-bus";
import LoginBox from "./LoginBox";

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    LoginBox,
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default',
    loginModal: false,
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    let t = this;

    EventBus.$on('loginModal', function (status) {
      t.loginModal = status;
    });

    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>
