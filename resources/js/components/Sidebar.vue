<template>
  <div class="layout__left-column layout__sticky">
    <div class="sidebar">
      <div class="sidebar__scroll vb vb-visible" style="position: relative; overflow: hidden;">
        <div data-v-23da34b5="" class="vb-content"
             style="display: block; overflow: hidden scroll; height: 100%; width: calc(100% + 17px);">
          <div data-v-23da34b5="" class="sidebar__spacer lm-hidden"></div>
          <main-list/>
          <div class="sidebar__tree-list sidebar__tree-list--limited">
            <div class="sidebar__tree-list__title l-flex l-fa-center l-ph-20 lm-ph-15">
              <router-link class="not-active" :to="{ name: 'subs'}">Подписки</router-link>
            </div>
            <div class="sidebar__tree-list__title l-flex l-fa-center l-ph-20 lm-ph-15" v-if="!Object.keys(subs).length">
              <span class="not-active">
                Пусто
              </span>
            </div>

            <router-link v-for="subsite in subs" :key="subsite.slug"
                         v-show="subsite.isVisible"
                         :to="{ name: 'subsite', params: {'slug': subsite.slug} }"
                         class="sidebar__tree-list__item l-ph-20 lm-ph-15 sidebar__tree-list__item--with-image">
              <img class="sidebar__tree-list__item__image"
                   :src="subsite.icon" lazy="loaded" alt="">
              <p class="sidebar__tree-list__item__name">{{ subsite.title }}</p>
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

  export default {
    name: "Sidebar",
    components: {MainList},
    data() {
      return {
        hide: true,
        subs: {},
        active: []
      }
    },
    computed: mapGetters({
      user: 'auth/user',
      userSubs: 'auth/userSubs',
    }),
    mounted() {
      this.subs = this.user ? this.userSubs : window.config.categories;
      this.showAll(false)

      EventBus.$on('sidebarShow', (status) => {
        this.show = status;
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
          this.subs[prop]['isVisible'] = i <= 6;
          i++;
        });
      },
    }
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

  .router-link-active {
    background: #fff;
  }

  .not-active.router-link-active {
    background: #fff0;
  }
</style>
