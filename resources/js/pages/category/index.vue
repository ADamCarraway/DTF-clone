<template>
  <div class="page page--index page--subsites lm-mt-0 l-pb-15 lm-pb-0 l-clear">
    <div class="subsites_catalog">
      <div class="ui-tabs ui-tabs--default lm-hidden l-island-bg">
        <div class="ui-tabs__scroll">
          <div class="ui-tabs__content l-island-a">
            <a href="https://dtf.ru/subs" class="ui-tab ui-tab--active ">
              <span class="ui-tab__label"> Подписки</span>
            </a>
            <!--            <a href="https://dtf.ru/subs/companies" class="ui-tab  ">-->
            <!--              <span class="ui-tab__label">Компании</span>-->
            <!--            </a>-->
          </div>
        </div>
      </div>
      <div class="subsites_catalog__search l-island-bg l-pv-15">
        <div class="l-island-a">
          <ion-icon name="search-outline"></ion-icon>
          <input v-model="search" class="subsites_catalog__search__bar l-ml-15" placeholder="Поиск"
                 data-gtm="Subsites catalog – Search">
        </div>
      </div>
      <div class="subsites_catalog__content l-island-bg">
        <div v-for="item in subs" :key="item.slug" class="subsites_catalog_item l-island-a l-pv-20">
          <div class="subsite_card_simple" :class="{'subsite_card_simple_short': (item.slug in subscriptions)}">
            <router-link :to="{ name: 'category', params: { slug: item.slug }  }"
                         class="subsite_card_simple__avatar l-block l-s-30 l-mins-30">
              <img class="andropov_image " style="background-color: transparent;"
                   :src="item.icon">
            </router-link>
            <div class="subsite_card_simple__info l-ml-15 l-pt-1 l-block">
              <router-link :to="{ name: 'category', params: { slug: item.slug }  }"
                           class="subsite_card_simple__title l-block l-fw-500">
                <span>{{item.title}}</span>
              </router-link>
              <p v-if="!(item.slug in subscriptions)" class="subsite_card_simple__description l-mt-2">
                <span v-if="item.description.length > 97">
                  {{ item.description.slice(0,97)+'...' }}
                </span>
                <span v-else>
                  {{ item.description}}
                </span>
              </p>
            </div>
            <div class="subsite_card_simple__controls l-ml-30">
              <div
                class="subsite_subscribe_button subsite_subscribe_button--size-small subsite_subscribe_button--notifications-disabled subsite_subscribe_button--active-short subsite_subscribe_button--mobile-short l-ml-12 subsite_subscribe_button--state-inactive ">
                <div class="subsite_subscribe_button__main ui-splash">
                  <div class="ui-button ui-button--subscribe ui-button--5 ui-button--wide ui-button--small"
                       v-if="!(item.slug in subscriptions)"
                       @click="subscribe(1, item)">
                    <i class="el-icon-plus"></i>
                    <span>Подписаться</span>
                  </div>

                  <div v-if="item.slug in subscriptions" @mouseover="isHovering = true" @mouseout="isHovering = false"
                       @click="subscribe(0, item)"
                       class="ui-button ui-button--subscribed ui-button--5 ui-button--wide ui-button--only-icon ui-button--small">
                    <ion-icon name="checkmark-outline"></ion-icon>
                    <span>Подписан</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-show="subs.length === 0" class="subsites_catalog__dummy l-pv-50 subsites_catalog__dummy--shown">Ничего нет</div>

    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import axios from "axios";
  import {forEach} from "../../helpers";

  export default {
    name: "index",
    data() {
      return {
        subs: [],
        isHovering: false,
        search: ''
      }
    },
    watch: {
      search(value) {
        this.search = value;
        this.getData()
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
        subscriptions: 'auth/subscriptions',
      }),
    },
    methods: {
      getData() {
        axios.get('/api/subs?search=' + this.search)
          .then((data) => {
            this.subs = data.data
          });
      },
      subscribe(type, data) {
        if (!type) {
            axios.delete('/api/unfollow', {data: {'followable': data.type, 'id': data.id}}).then((res) => {
              this.$store.dispatch('auth/destroySubscription', {slug: data.slug})
          })
        }

        if (type) {
          axios.post('/api/follow', {'followable': data.type, 'id': data.id}).then((res) => {
            this.subs[data.slug]['isVisible'] = Object.keys(this.subscriptions).length < 7;

            this.$store.dispatch('auth/addSubscription', {sub: this.subs[data.slug]})
          })
        }
      },
    },
    created() {
      this.getData();
    },
    metaInfo() {
      return {title: 'Каталог подсайтов'}
    }
  }
</script>

<style scoped>

</style>
