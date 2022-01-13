<template>
  <div id="app">
    <loading ref="loading"/>

    <transition name="page" mode="out-in">
      <component :is="layout" v-if="layout"/>
    </transition>

    <el-dialog
        :visible.sync="loginModal"
        :show-close="false"
        :custom-class="'login-modal'">
      <span slot="title"></span>
      <login-box/>
      <span slot="footer"></span>
    </el-dialog>


    <create-post-modal :data="readablePostData" v-if="editorShow"/>

  </div>
</template>

<script>
import Loading from './Loading'
import EventBus from "../plugins/event-bus";
import LoginBox from "./LoginBox";
import CreatePostModal from "./Blocks/CreatePostModal";

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
    CreatePostModal,
    LoginBox,
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default',
    loginModal: false,
    editorShow: false,
    readablePostData: null
  }),

  metaInfo() {
    const {appName} = window.config

    return {
      title: appName,
      titleTemplate: `%s`
    }
  },

  mounted() {
    let t = this;

    EventBus.$on('loginModal', function (status) {
      t.loginModal = status;
    });

    EventBus.$on('editorShow', function (status, data = null) {
      t.readablePostData = data;
      t.editorShow = status;
    });

    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout(layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>
