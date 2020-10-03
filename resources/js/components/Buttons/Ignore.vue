<template>
  <div>
    <div v-if="check" @click="toIgnore(1)"
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
      check: function () {
        if (!this.user) return true;

        return !this.data.is_ignore;
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
        this.data.is_ignore = true;

        this.$store.dispatch('auth/changeSubscriptionField', {
          slug: this.data.slug,
          key: 'is_ignore',
          value: 'true'
        });

        this.$Notify.success({
          message: 'Добавлено в черный список'
        })
      },
      changeForUnIgnore() {
        this.data.is_ignore = false;

        this.$store.dispatch('auth/changeSubscriptionField', {
          slug: this.data.slug,
          key: 'is_ignore',
          value: 'false'
        });

        this.$Notify.success({
          message: 'Убрано из черного списка'
        })
      }
    }
  }
</script>

<style scoped>

</style>
