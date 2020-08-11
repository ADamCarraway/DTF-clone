<template>
  <div class="layout__left-column layout__sticky" v-if="show">
    <div class="sidebar">
      <div class="sidebar__scroll vb vb-visible" style="position: relative; overflow: hidden;">
        <div data-v-23da34b5="" class="vb-content"
             style="display: block; overflow: hidden scroll; height: 100%; width: calc(100% + 17px);">
          <div data-v-23da34b5="" class="sidebar__spacer lm-hidden"></div>
          <main-list/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import MainList from "./MainList";
  import EventBus from "../plugins/event-bus";

  export default {
    name: "Sidebar",
    components: {MainList},
    data(){
      return{
        show: true
      }
    },
    mounted() {
      let t = this;

      EventBus.$on('sidebarShow', function (status) {
        t.show = status;
      });
    },
  }
</script>

<style scoped>
  .sidebar {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
  }

  .sidebar__scroll {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex: 1;
    flex: 1;
  }

  .sidebar .vb-content {
    display: -ms-flexbox !important;
    display: flex !important;
    -ms-flex-flow: column;
    flex-flow: column;
  }

  .sidebar__spacer {
    min-height: 15px;
  }
</style>
