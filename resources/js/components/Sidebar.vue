<template>
  <div class="layout__left-column layout__sticky" v-show="!hideSidebar">
    <div class="sidebar">
      <div class="sidebar__scroll vb vb-visible" style="position: relative; overflow: hidden;">
        <div class="vb-content"
             style="display: block; overflow: hidden scroll; height: 100%; width: 100%;">
          <main-list/>
          <div class="sidebar__tree-list sidebar__tree-list--limited">
            <div class="sidebar__tree-list__title l-flex l-fa-center l-ph-20 lm-ph-15" v-if="!Object.keys(subs).length">
              <span class="not-active">
                Пусто
              </span>
            </div>

            <router-link v-for="item in subs" :key="item.slug"
                         v-show="item.isVisible"
                         :to="{ name: item.type, params: {'slug': item.slug} }"
                         class="sidebar__tree-list__item lm-ph-15 sidebar__tree-list__item--with-image">
              <div class="sidebar-tree-list-item__link">
                <img class="sidebar__tree-list__item__image"
                     :src="item.icon" lazy="loaded" alt="">
                <p class="sidebar__tree-list__item__name">{{ item.title }}</p>
                <favorite :data="item"></favorite>
              </div>
            </router-link>

            <div class="sidebar__tree-list__button l-ph-20 lm-ph-15" @click="" v-if="Object.keys(subs).length > 6">
              <span v-if="hide" @click="showAll(false)">скрыть</span>
              <span v-else @click="showAll(true)">показать еще</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import MainList from "./MainList";
  import EventBus from "../plugins/event-bus";
  import {mapGetters} from "vuex";
  import {forEach} from "../helpers"
  import axios from "axios";
  import Favorite from "./Buttons/Favorite";

  export default {
    name: "Sidebar",
    components: {Favorite, MainList},
    data() {
      return {
        hideSidebar: false,
        hide: true,
        subs: {},
        active: []
      }
    },
    computed: mapGetters({
      user: 'auth/user',
      subscriptions: 'auth/subscriptions',
    }),
    mounted() {
      this.subs = this.user ? this.subscriptions : window.config.categories;
      this.showAll(false)

      EventBus.$on('hideSidebar', () => {
        this.hideSidebar = !this.hideSidebar;
      });
    },

    methods: {
      showAll(status) {
        this.hide = status;

        if (status) return Object.keys(this.subs).map((key) => {
          this.subs[key]['isVisible'] = true;
        });

        let i = 0;
        forEach(this.subs, (value, prop, obj) => {
          this.subs[prop]['isVisible'] = i <= 5;
          i++;
        });
      }
    }
  }
</script>

<style scoped>

</style>
