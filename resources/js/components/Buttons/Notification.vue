<template>
  <div v-if="data" class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
    <div v-if="(data[key] in inObj) && !this.user[append].includes(data.id)" @click="notify(1)">
      <div class="v-button__icon">
        <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
           aria-hidden="true"></i>
        <i v-else class="far fa-bell"></i>
      </div>
    </div>

    <div v-if="(data[key] in inObj) && this.user[append].includes(data.id)" @click="notify(0)">
      <div class="v-button__icon">
        <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
           aria-hidden="true"></i>
        <i v-else class="fas fa-bell"></i>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import axios from "axios";

  export default {
    name: "Notification",
    props: ['data', 'type'],
    data() {
      return {
        loadingNotify: false,
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
      append: function () {
        return this.type === 'users' ? 'user_notify' : 'category_notify';
      },
      inObj: function () {
        return this.type === 'users' ? this.users : this.categories;
      },
    },
    methods: {
      notify(type) {
        this.loadingNotify = true;
        if (type) {
          axios.post('/api/notifications/subscribe/' + this.type + 'Notify/' + this.data.id).then((res) => {
            this.changeForNotify();
          }).catch(() => {
            this.loadingNotify = false;
          })
        }

        if (!type) {
          axios.post('/api/notifications/unsubscribe/' + this.type + 'Notify/' + this.data.id).then((res) => {
            this.changeForUnNotify();
          }).catch(() => {
            this.loadingNotify = false;
          })
        }
      },
      changeForNotify() {
        if (this.type === 'categories') {
          this.user.category_notify.push(this.data.id);
          this.$store.dispatch('auth/updateUser', {user: {'category_notify': this.user.category_notify}});
        } else {
          this.user.user_notify.push(this.data.id)
          this.$store.dispatch('auth/updateUser', {user: {'user_notify': this.user.user_notify}});
        }
        this.$Notify.success({
          message: 'Мы уведомим вас о новых записях'
        })
        this.loadingNotify = false;
      },
      changeForUnNotify() {
        if (this.type === 'categories') {
          const index = this.user.category_notify.indexOf(this.data.id);
          this.user.category_notify.splice(index, 1);

          this.$store.dispatch('auth/updateUser', {user: {'category_notify': this.user.category_notify}})

        } else {
          const index = this.user.user_notify.indexOf(this.data.id);
          this.user.user_notify.splice(index, 1);

          this.$store.dispatch('auth/updateUser', {user: {'user_notify': this.user.user_notify}});
        }
        this.$Notify.success({
          message: 'Вы отписались от уведомлений о новых записях'
        })
        this.loadingNotify = false;
      }
    },
  }
</script>

<style scoped>

</style>
