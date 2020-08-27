<template>
  <div class="layout__left-column layout__sticky" v-if="show">
    <div class="sidebar">
      <div class="sidebar__scroll vb vb-visible" style="position: relative; overflow: hidden;">
        <div data-v-23da34b5="" class="vb-content"
             style="display: block; overflow: hidden scroll; height: 100%; width: calc(100% + 17px);">
          <div data-v-23da34b5="" class="sidebar__spacer lm-hidden"></div>
          <main-list/>

          <div class="sidebar__tree-list sidebar__tree-list--limited" v-if="subsites">
            <div class="sidebar__tree-list__title l-flex l-fa-center l-ph-20 lm-ph-15">
              <router-link class="not-active" :to="{ name: 'subs'}">Подписки</router-link>
            </div>

            <router-link v-for="subsite in subsites" :key="subsite.slug"
                         :to="{ name: 'subsite', params: {'slug': subsite.slug} }"
                         class="sidebar__tree-list__item l-ph-20 lm-ph-15 sidebar__tree-list__item--with-image">
              <img class="sidebar__tree-list__item__image"
                   :src="subsite.icon" lazy="loaded">
              <p class="sidebar__tree-list__item__name">{{ subsite.title}}</p>
            </router-link>

            <div class="sidebar__tree-list__button l-ph-20 lm-ph-15" @click="showMore()">
              <span>{{ btn }}</span>
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

  export default {
    name: "Sidebar",
    components: {MainList},
    data() {
      return {
        show: true,
        hideList: true,
        subsites: [],
        showed: {},
        hidden: {},
        btn: 'показать еще'
      }
    },
    mounted() {
      let t = this;

      EventBus.$on('sidebarShow', function (status) {
        t.show = status;
      });

      EventBus.$on('modifySusiteList', function () {
        t.modifyList()
      });
    },

    methods: {
      showMore() {
        this.hideList = !this.hideList
        this.modifyList();
      },

      modifyList() {
        let i = 0;

        if (!this.hideList) {
          this.subsites = window.config.categories;
        } else {
          this.subsites = this.showed
        }
      }
    },
    created() {
      let i = 0;
      for (const [key, value] of Object.entries(window.config.categories)) {
        if (i >= 6) {
          this.hidden[key] = value;
        } else {
          this.showed[key] = value;
        }
        i++;
      }

      this.subsites = this.showed
      // this.showed = window.config.categories
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
