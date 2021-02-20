<template>
  <div v-if="data">
    <div @click="subscribe(0)" v-if="data.slug in subscriptions"
         :class="{'v-subscribe-button__unsubscribe v-button v-button--default v-button--size-default': !small,
         'ui-button ui-button--subscribe ui-button--5 ui-button--only-icon ui-button--small': small}">
      <div class="v-button__icon">
        <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status"
           aria-hidden="true"></i>
        <i v-else class="fas fa-times icon--ui_close color-red"></i>
      </div>
      <span class="v-button__label">Отписаться</span>
    </div>

    <div @click="subscribe(1)" v-if="!(data.slug in subscriptions)"
         :class="{'v-subscribe-button__unsubscribe v-button v-button--default v-button--size-default': !small,
         'ui-button ui-button--subscribe ui-button--5 ui-button--only-icon ui-button--small': small}">
      <div class="v-button__icon">
        <i v-if="loadingSub" class="spinner-border spinner-border-sm mr-10" role="status"
           aria-hidden="true"></i>
        <i v-else class="fas fa-plus icon--ui_plus color-green"></i>
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
    props: ['data', 'small'],
    data() {
      return {
        loadingSub: false,
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
        subscriptions: 'auth/subscriptions',
      }),
    },
    methods: {
      subscribe(type) {
        this.loadingSub = true;
        if (!type) {
          axios.delete('/api/unfollow', {data: {'followable': this.data.type, 'id': this.data.id}}).then((res) => {
            this.changeForUnSubscribe();
            this.loadingSub = false;
          }).catch(() => {
            this.loadingSub = false;
          })
        }

        if (type) {
          axios.post('/api/follow', { 'followable': this.data.type, 'id': this.data.id}).then((res) => {
            this.changeForSubscribe();
            this.loadingSub = false;
          }).catch(() => {
            this.loadingSub = false;
          })
        }
      },
      changeForSubscribe() {
        if (this.data.type === 'category') {
          this.data['isSub'] = true;
          this.data['isVisible'] = Object.keys(this.subscriptions).length < 7;

          this.$store.dispatch('auth/addSubscription', {sub: this.data})
        }else{
          this.$store.dispatch('auth/addSubscription', {sub: this.data});
        }
      },
      changeForUnSubscribe() {
        this.data.is_notify = false;
        this.$store.dispatch('auth/changeSubscriptionField', {
          slug: this.data.slug,
          key: 'is_notify',
          value: false
        });

        if (this.data === 'category') {
          this.$store.dispatch('auth/destroySubscription', {slug: this.data.slug})
        }else {
          this.$store.dispatch('auth/destroySubscription', {slug: this.data.slug});
        }

      },
    },
  }
</script>

<style scoped>

</style>
