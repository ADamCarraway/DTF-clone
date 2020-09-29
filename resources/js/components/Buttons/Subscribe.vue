<template>
  <div v-if="data">
    <div @click="subscribe(0)" v-if="data[key] in inObj"
         class="v-subscribe-button__unsubscribe v-button v-button--default v-button--size-default">
      <div class="v-button__icon">
        <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status"
           aria-hidden="true"></i>
        <i v-else class="fas fa-times icon--ui_close"></i>
      </div>
      <span class="v-button__label">Отписаться</span>
    </div>

    <div @click="subscribe(1)" v-if="!(data[key] in inObj)"
         class="v-subscribe-button__subscribe v-button v-button--blue v-button--size-default">
      <div class="v-button__icon">
        <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status"
           aria-hidden="true"></i>
        <i v-else class="fas fa-plus icon--ui_plus"></i>
      </div>
      <span class="v-button__label">Подписаться</span>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import {mapGetters} from "vuex";

  export default {
    name: "Subscribe",
    props: ['data', 'type'],
    data() {
      return {
        loadingSub: false,
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
        categories: 'auth/userCategoriesSubs',
        users: 'auth/userUsersSubs',
      }),
      key: function () {
        return this.type === 'users' ? 'id' : 'slug';
      },
      inObj: function () {
        return this.type === 'users' ? this.users : this.categories;
      }

    },
    methods: {
      subscribe(type) {
        this.loadingSub = true;
        if (!type) {
          axios.post('/api/' + this.data.id + '/' + this.type + '/unsubscribe', this.form).then((res) => {
            this.changeForUnSubscribe();
            this.loadingSub = false;
          }).catch(() => {
            this.loadingSub = false;
          })
        }

        if (type) {
          axios.post('/api/' + this.data.id + '/' + this.type + '/subscribe', this.form).then((res) => {
            this.changeForSubscribe();
            this.loadingSub = false;
          }).catch(() => {
            this.loadingSub = false;
          })
        }
      },
      changeForSubscribe() {
        if (this.type === 'categories') {
          this.data['isSub'] = true;
          this.data['isVisible'] = Object.keys(this.categories).length < 7;

          this.$store.dispatch('auth/addUserCategorySubscription', {sub: this.data})
        }else{
          this.$store.dispatch('auth/addUserUserSubscription', {sub: this.data});
        }
      },
      changeForUnSubscribe() {
        if (this.type === 'categories') {
          this.$store.dispatch('auth/destroyUserCategorySubscription', {slug: this.data.slug})
        }else {
          this.$store.dispatch('auth/destroyUserUserSubscription', {id: this.data.id});
        }
      }
    }
  }
</script>

<style scoped>

</style>
