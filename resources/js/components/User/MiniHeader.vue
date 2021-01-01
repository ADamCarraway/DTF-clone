<template>
  <div v-if="data" class="v-mini-header l-island-bg l-island-round" :class="{'v-mini-header--active': tabsPos <= 60}">
    <div class="v-header-avatar"
         :style="{ backgroundImage: `url('${data.icon}')` }">
    </div>
    <div class="v-mini-header__title">
      {{ data.title }}
    </div>

    <div v-if="data.type === 'user'">
      <user-tabs/>
    </div>
    <div v-else>
      <category-tabs :data="data"></category-tabs>
    </div>


    <div class="v-header-actions v-header-actions--mini" v-if="user && user.slug !== $route.params.slug">
      <div
        class="v-subscribe-button v-subscribe-button--full v-subscribe-button--with-notifications v-subscribe-button--state-active">
        <subscribe :data="data" :type="data.type"></subscribe>
        <notification :data="data" :type="data.type"></notification>
      </div>
      <ignore :data="data" :type="data.type"></ignore>

    </div>
  </div>
</template>

<script>
  import CategoryTabs from "./CategoryTabs";
  import Subscribe from "../Buttons/Subscribe";
  import Ignore from "../Buttons/Ignore";
  import Notification from "../../components/Buttons/Notification";
  import UserTabs from "./UserTabs";
  import {mapGetters} from "vuex";

  export default {
    name: "MiniHeader",
    components: {UserTabs, Ignore, Subscribe, CategoryTabs, Notification},
    props: ['data'],
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
    },
    data() {
      return {
        scrollPos: 0,
        tabsPos: 299,
      }
    },
    mounted() {
      let t = this;

      window.addEventListener('scroll', function (e) {
        t.scrollPos = window.scrollY;
        if (document.querySelector(".v-header__tabs") !== null) {
          t.tabsPos = document.querySelector(".v-header__tabs").getBoundingClientRect().top
        }
      })
    },
  }
</script>

<style scoped>

</style>
