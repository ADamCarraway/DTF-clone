<template>
  <div>
    <div v-if="check" @click="toIgnore(true)"
         class="at-dropdown-menu__item etc_control__item">Игнорировать
    </div>
    <div v-else @click="toIgnore(false)" class="at-dropdown-menu__item etc_control__item">Не игнорировать</div>
  </div>
</template>

<script>
  import axios from "axios";
  import {mapGetters} from "vuex";

  export default {
    name: "Ignore",
    props: ['data'],
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
      check: function () {
        if (!this.user) return true;

        return !this.data.is_ignore;
      },
    },
    methods: {
      toIgnore(type) {
        if (type) {
          axios.post('/api/ignore/store/' + this.data.type + 'Ignore/' + this.data.id).then((res) => {
            this.changeForIgnore(type);
          })
        }

        if (!type) {
          axios.post('/api/ignore/destroy/' + this.data.type + 'Ignore/' + this.data.id).then((res) => {
            this.changeForIgnore(type)
          })
        }
      },
      changeForIgnore(status) {
        this.data.is_ignore = status;

        this.$store.dispatch('auth/changeSubscriptionField', {
          slug: this.data.slug,
          key: 'is_ignore',
          value: status
        });

        if (status) {
          this.$Notify.success({
            message: 'Добавлено в черный список'
          })
        } else {
          this.$Notify.success({
            message: 'Убрано из черного списка'
          })
        }
      },

    }
  }
</script>

<style scoped>

</style>
