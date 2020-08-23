<template>
  <div class="page page--subsites lm-mt-0 l-pb-15 lm-pb-0 l-clear">
    <div class="subsites_catalog">
      <div class="ui-tabs ui-tabs--default lm-hidden l-island-bg">
        <div class="ui-tabs__scroll">
          <div class="ui-tabs__content l-island-a">
            <a href="https://dtf.ru/subs" class="ui-tab ui-tab--active ">
              <span class="ui-tab__label"> Подписки</span>
            </a>
            <a href="https://dtf.ru/subs/companies" class="ui-tab  ">
              <span class="ui-tab__label">Компании</span>
            </a>
          </div>
        </div>
      </div>
      <div class="subsites_catalog__search l-island-a l-island-bg l-pv-15">
        <i class="fas fa-search"></i>
        <input class="subsites_catalog__search__bar l-ml-15" placeholder="Поиск"
               data-gtm="Subsites catalog – Search">
      </div>
      <div class="subsites_catalog__content l-island-bg">
        <div v-for="item in subs" :key="item.id" class="subsites_catalog_item l-island-a l-pv-20">
          <div class="subsite_card_simple">
            <router-link :to="{ name: 'subs.show', params: { slug: item.slug }  }"
                         class="subsite_card_simple__avatar l-block l-s-38 l-mins-38 lm-s-40 lm-mins-40">
              <img class="andropov_image " style="background-color: transparent;"
                   :src="item.icon">
            </router-link>
            <div class="subsite_card_simple__info l-ml-15 l-pt-1 l-block">
              <router-link :to="{ name: 'subs.show', params: { slug: item.slug }  }"
                           class="subsite_card_simple__title l-block l-fw-500">
                <span>{{item.title}}</span>
              </router-link>
              <p class="subsite_card_simple__description l-mt-2">{{ item.description }}</p>
            </div>
            <div class="subsite_card_simple__controls l-ml-30">
              <div
                class="subsite_subscribe_button subsite_subscribe_button--size-small subsite_subscribe_button--notifications-disabled subsite_subscribe_button--active-short subsite_subscribe_button--mobile-short l-ml-12 subsite_subscribe_button--state-inactive ">
                <div class="subsite_subscribe_button__main ui-splash">
                  <at-button v-show="!item.is_subscriber" icon="icon-plus"
                             @click="subscribe(item.id)">Подписаться
                  </at-button>

                  <at-button style="margin-left: auto;color: green" v-show="item.is_subscriber"
                             @click="subscribe(item.id)"
                             icon="icon-check"></at-button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import axios from "axios";

  export default {
    name: "index",
    data() {
      return {
        subs: []
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user'
      }),
    },
    methods: {
      getSubs() {
        axios.get('/api/subs').then(response => {
          this.subs = response.data
        })
      }
    },
    created() {
      this.getSubs();
    }
  }
</script>

<style scoped>

</style>
