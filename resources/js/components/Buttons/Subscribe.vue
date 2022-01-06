<template>
  <div v-if="data">
    <div @click="subscribe(0)" v-if="data.is_follow"
         class="v-button v-button--default v-button--size-default ui-button--only-icon">
      <div class="v-button__icon">
        <ion-icon name="close-outline" :class="'v-button__icon v-button__icon--new color-red'"></ion-icon>
      </div>
      <!--      <span class="v-button__label">Отписаться</span>-->
    </div>

    <div @click="subscribe(1)" v-if="!data.is_follow"
         :class="{'v-subscribe-button__subscribe v-button v-button--blue v-button--size-default': !small,
         'v-button v-button--default v-button--size-default ui-button--only-icon': small}">
      <div class="v-button__icon">
        <ion-icon name="person-add-outline" :class="'v-button__icon v-button__icon--new'"></ion-icon>
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
        axios.post('/api/follow', {'followable': this.data.type, 'id': this.data.id}).then((res) => {
          this.changeForSubscribe();
          this.loadingSub = false;
        }).catch(() => {
          this.loadingSub = false;
        })
      }
    },
    changeForSubscribe() {
      this.data.is_follow = true;
      this.data.is_follow = true;
      this.data['isVisible'] = Object.keys(this.subscriptions).length < 7;

      this.$store.dispatch('auth/addSubscription', {sub: this.data})
    },
    changeForUnSubscribe() {
      this.data.is_notify = false;
      this.data.is_follow = false;
      this.$store.dispatch('auth/changeSubscriptionField', {
        slug: this.data.slug,
        key: 'is_notify',
        value: false
      });

      this.$store.dispatch('auth/destroySubscription', {slug: this.data.slug})

    },
  },
}
</script>

<style scoped>

</style>
