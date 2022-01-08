<template>
  <div class="v-form-section">

    <block-keywords/>

    <div class="user-settings__container">
      <label class="v-form-section__label">
        Пользователи
      </label>
      <div class="v-field--text v-field v-field--default w-100">
        <div class="v-field__wrapper">
          <el-select
              v-model="ignorable"
              @change="addToBlock"
              filterable
              remote
              :remote-method="search"
              placeholder="Имя"
              noDataText="Ничего не найдено"
              class="v-text-input__input">
            <el-option
                v-for="item in results"
                :key="item.id"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </div>
      </div>
      <div class="settings-list-subsites__container">
        <div class="v-list-subsites">
          <div class="v-list-subsites__content v-list-subsites__content--columns-1">
            <div class="v-list-subsites-item" v-for="item in list" :key="item.id">
              <router-link :to="{ name: item.ignorable.type, params: {slug: item.ignorable.slug} }"
                           class="v-list-subsites-item__main">
                <div class="v-list-subsites-item__image"
                     :style="{ backgroundImage: `url('${item.ignorable.icon}')`}"></div>
                <div class="v-list-subsites-item__label-container">
                <span :title="item.ignorable.title" class="v-list-subsites-item__label">{{
                    item.ignorable.title
                  }}</span>
                </div>
              </router-link>

              <div class="etc-control v-etc v-etc--right">
                <div class="v-button v-button--default v-button--size-default" @click="destroy(item.id)">
                  <div class="v-button__icon">
                    <ion-icon name="trash-outline"></ion-icon>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
          <div slot="no-results">
          </div>
          <div slot="no-more"></div>
        </infinite-loading>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {mapGetters} from 'vuex'
import InfiniteLoading from "vue-infinite-loading";
import BlockKeywords from "./BlockKeywords";

export default {
  name: "BlockList",
  components: {BlockKeywords, InfiniteLoading},

  scrollToTop: true,

  data() {
    return {
      list: [],
      page: 1,
      infiniteId: +new Date(),
      results: [],
      ignorable: null
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    search(query) {
      if (query !== '' && query.length > 3) {
        axios.get('/api/settings/block-list/search?search=' + query).then((response) => {
          this.results = response.data
        })
      }
    },
    addToBlock(id) {
      axios.post('/api/ignore', {'ignorable': 'user', 'id': id}).then((res) => {
        this.ignorable = null;
        this.list.push(res.data);
      })
    },
    destroy(id) {
      axios.post('/api/settings/block-list/' + id + '/destroy').then((response) => {
        for (let i = 0; i < this.list.length; i++) {
          if (this.list[i].id === id) this.list.splice(i, 1)
        }
      })
    },
    infiniteHandler($state) {
      axios.get('/api/settings/block-list?page=' + this.page)
          .then((data) => {
            if (data.data.data.length) {
              this.page = this.page + 1;
              $.each(data.data.data, (key, value) => {
                this.list.push(value);
              });

              $state.loaded();
            } else {
              $state.complete();
            }
          });
    },
  },
}
</script>

<style scoped>
/*.el-checkbox__inner{*/
/*  width: 18px!important;*/
/*  height: 18px!important;*/
/*}*/
.item {
  display: block;
  margin-top: 8px;
  padding: 4px 0 4px 0px;
  font-size: 16px;
  color: #000;
  font-weight: 100;
}
</style>
