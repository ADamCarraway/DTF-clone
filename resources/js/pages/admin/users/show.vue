<template>
  <div class="page page--entry">
    <div class="l-island-bg l-island-a l-pv-30 lm-pt-15 lm-pb-30 w_1020 admin-page">
      <h3 class="mb-3">
        <a @click="$router.go(-1)" class="settings-header user-settings__header router-link-active" style="cursor: pointer">
          <ion-icon name="chevron-back-outline"
                    class="settings-header__icon icon icon--v_arrow_left md hydrated" role="img"
                    aria-label="chevron back outline"></ion-icon>
          <span class="settings-header__text">
              Назад
            </span>
        </a>
      </h3>
      <div class="subsite_head__row">
        <div class="subsite_head__name l-fs-30 lm-fs-22 l-lh-30 l-fw-600">
          {{ user.name }}
        </div>
        <div class="" style="font-size: 16px; display: flex; cursor: pointer;">
          <ban-user :user="user" class="ml-3"/>
          <delete-user :user="user" class="ml-3"/>
        </div>
      </div>
      <br>
      <br>
      <br>
      <div class="row">
        <div class="col-6">
          <update-form :user="user"/>
        </div>
        <div class="col-6">
          <label class="v-form-section__label">
            Фильтр ленты по словам
          </label>
          <div class="hashtag-container" v-if="user && user.ignoredKeywords.length">
            <div class="v-hashtag"
                 v-for="(keyword, index) in user.ignoredKeywords"
                 :key="keyword"
                 v-if="index < limit">
              <div title="test" class="v-hashtag__text">
                {{ keyword }}
              </div>
            </div>
            <button class="show-all-button" @click="show()" v-if="user.ignoredKeywords.length > 6">
            <span class="show-all-button__text">
              <span v-if="!showAll">Показать все</span>
              <span v-else>Скрыть</span>
            </span>
            </button>
          </div>
          <div class="hashtag-container" v-else>
            <div class="v-field__wrapper">
              <div class="v-text-input v-text-input--default">
                <input value="Пусто" class="v-text-input__input" type="text" disabled>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6">
          <label class="v-form-section__label mt-4">
            Последние посты <a href="" class="float-right" style="font-size: 13px">все</a>
          </label>
          <last-posts :user="user" v-if="user"/>
        </div>
        <div class="col-6">
          <label class="v-form-section__label mt-4">
            Последние комментарии <a href="" class="float-right" style="font-size: 13px">все</a>
          </label>
          <last-comments :user="user"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from "axios";
import UpdateForm from "../../../components/Admin/User/UpdateForm";
import LastPosts from "../../../components/Admin/User/LastPosts";
import BanUser from "../../../components/Admin/User/Ban";
import DeleteUser from "../../../components/Admin/User/Delete";
import RoleModalUser from "../../../components/Admin/User/RoleModal";
import LastComments from "../../../components/Admin/User/LastComments";

export default {
  name: "show",
  components: {LastComments, RoleModalUser, DeleteUser, BanUser, LastPosts, UpdateForm},
  middleware: ['admin'],
  data() {
    return {
      user: [],
      showAll: false,
      limit: 10
    }
  },
  // computed: {
  //   ...mapGetters({
  //     user: 'auth/user',
  //   }),
  // },
  methods: {
    show() {
      this.showAll = !this.showAll
      this.limit = this.showAll ? this.user.ignoredKeywords.length : 6
    },
    getUser() {
      axios.get('/api/admin/users/' + this.$route.params.id + '/show').then((res) => {
        this.user = res.data
      })
    },
  },
  created() {
    this.getUser()
  },
  metaInfo() {
    return {title: this.user.name}
  }
}
</script>

<style scoped>

</style>
