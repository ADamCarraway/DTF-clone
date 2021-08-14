<template>
  <div
    class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
    <div v-if="!data.is_notify" @click="notify(true)">
      <div class="v-button__icon">
        <ion-icon src="/icons/notifications-outline.svg"></ion-icon>
      </div>
    </div>

    <div v-if="data.is_notify" @click="notify(false)">
      <div class="v-button__icon">
        <ion-icon src="/icons/notifications-off-outline.svg"></ion-icon>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import axios from "axios";

  export default {
    name: "Notification",
    props: ['data'],
    data() {
      return {
        loadingNotify: false,
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
        subscriptions: 'auth/subscriptions',
      }),
    },
    methods: {
      notify(type) {
        this.loadingNotify = true;
        if (!type) {
          axios.delete('/api/notification', {data: {'notifiable': this.data.type, 'id': this.data.id}}).then((res) => {
            this.changeForNotify(type);
            this.loadingNotify = false;
          }).catch(() => {
            this.loadingNotify = false;
          })
        }

        if (type) {
          axios.post('/api/notification', {'notifiable': this.data.type, 'id': this.data.id}).then((res) => {
            this.changeForNotify(type);
            this.loadingNotify = false;
          }).catch(() => {
            this.loadingNotify = false;
          })
        }
      },
      changeForNotify(status) {
        this.data.is_notify = status;
        this.$store.dispatch('auth/changeSubscriptionField', {
          slug: this.data.slug,
          key: 'is_notify',
          value: status
        });

        this.$notify({
          message: status ? 'Мы уведомим вас о новых записях' : 'Вы отписались от уведомлений о новых записях',
          type: 'success'
        });

      },
    },
  }
</script>

<style scoped>

</style>
