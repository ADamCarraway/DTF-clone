<template>
  <div v-if="data">
    <div v-if="!this.user[key].includes(data.id)" @click="toIgnore(1)"
         class="at-dropdown-menu__item etc_control__item">Игнорировать
    </div>
    <div v-else @click="toIgnore(0)" class="at-dropdown-menu__item etc_control__item">Не игнорировать</div>
  </div>
</template>

<script>
  import axios from "axios";
  import {mapGetters} from "vuex";

  export default {
    name: "Ignore",
    props: ['data', 'type'],
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
      key: function () {
        return this.type === 'users' ? 'users_ignore' : 'categories_ignore';
      },
    },
    methods: {
      toIgnore(type) {
        if (type) {
          axios.post('/api/ignore/store/' + this.type + 'Ignore/' + this.data.id).then((res) => {
            this.changeForIgnore();
          })
        }

        if (!type) {
          axios.post('/api/ignore/destroy/' + this.type + 'Ignore/' + this.data.id).then((res) => {
            this.changeForUnIgnore()
          })
        }
      },
      changeForIgnore() {
        if (this.type === 'categories') {
          this.user.categories_ignore.push(this.data.id)
          this.$store.dispatch('auth/updateUser', {user: {'categories_ignore': this.user.categories_ignore}})
          this.$Notify.success({
            message: 'Подсайт добавлен в черный список'
          })
        } else {
          this.user.users_ignore.push(this.data.id)
          this.$store.dispatch('auth/updateUser', {user: {'users_ignore': this.user.users_ignore}})
          this.$Notify.success({
            message: 'Пользователь добавлен в черный список'
          })
        }
      },
      changeForUnIgnore() {
        if (this.type === 'categories') {
          const index = this.user.categories_ignore.indexOf(this.data.id);
          this.user.categories_ignore.splice(index, 1);

          this.$store.dispatch('auth/updateUser', {user: {'categories_ignore': this.user.categories_ignore}})
          this.$Notify.success({
            message: 'Подсайт убран из черного списка'
          })
        } else {
          const index = this.user.users_ignore.indexOf(this.data.id);
          this.user.users_ignore.splice(index, 1);

          this.$store.dispatch('auth/updateUser', {user: {'users_ignore': this.user.users_ignore}})
          this.$Notify.success({
            message: 'Пользователь убран из черного списка'
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>
