<template>
  <div class="v-form-section">
    <label class="v-form-section__label">
      Фильтр ленты по словам
    </label>
    <div class="v-form-section__field d-flex justify-content-between">
      <div class="v-field--text v-field v-field--default w-100" ref="inputElement" data-length="17">
        <div class="v-field__wrapper">
          <div class="v-text-input v-text-input--default">
            <input v-model="keyword" class="v-text-input__input" type="text" maxlength="30" name="keyword"
                   placeholder="Ключевой #тег или слово">
          </div>
        </div>

        <div class="hashtag-container" v-if="keywords">
          <div class="v-hashtag"
               v-for="(keyword, index) in keywords"
               :key="keyword"
               v-if="index < limit">
            <div title="test" class="v-hashtag__text">
              {{ keyword }}
            </div>
            <button class="v-hashtag__close-button" @click="destroy(keyword)">
              <ion-icon name="close-outline" class="icon--v_close"></ion-icon>
            </button>
          </div>
          <button class="show-all-button" @click="show()" v-if="keywords.length > 6">
            <span class="show-all-button__text">
              <span v-if="!showAll">Показать все</span>
              <span v-else>Скрыть</span>
            </span>
          </button>
        </div>

      </div>

      <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default"
              @click="add"
              style="margin-left: 12px">
          <span class="v-button__label">
            <span>Добавить</span>
          </span>
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {mapGetters} from 'vuex'
import Password from "./Password";
import Social from "./Social";
import SettingHeader from "./Header";
import OnlineStatus from "./OnlineStatus";
import ShowPosts from "./ShowPosts";

export default {
  name: "BlockKeywords",
  scrollToTop: false,

  data() {
    return {
      keywords: [],
      keyword: '',
      showAll: false,
      limit: 6
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    show(){
      this.showAll = !this.showAll
      this.limit = this.showAll ? this.keywords.length : 6
    },
    add() {
      if (!this.keyword) return;

      axios.post('/api/settings/block-keywords', {'keyword': this.keyword}).then((response) => {
        this.keywords.push(this.keyword)
        this.keyword = ''
      }).catch(error => {
        this.$notify({
          message: 'Хештег или слово уже находится в черном списке',
          type: 'error',
        })
      })
    },
    get() {
      axios.get('/api/settings/block-keywords').then((response) => {
        this.keywords = response.data
      })
    },
    destroy(keyword) {
      axios.delete('/api/settings/block-keywords', {data: {'keyword': keyword}}).then((response) => {
        const index = this.keywords.indexOf(keyword);
        if (index > -1) {
          this.keywords.splice(index, 1);
        }
      })
    },
  },
  created() {
    this.get()
  }
}
</script>

<style scoped>

</style>
