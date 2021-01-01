<template>
  <el-dropdown trigger="click"  @command="toIgnore" v-if="user">
  <span class="el-dropdown-link">
   <i class="el-icon-more l-fs-22"></i>
  </span>
    <el-dropdown-menu slot="dropdown">
      <el-dropdown-item v-if="check" command="true"
           class="at-dropdown-menu__item etc_control__item">Игнорировать
      </el-dropdown-item>
      <el-dropdown-item v-else command="false" class="at-dropdown-menu__item etc_control__item">Не игнорировать</el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
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
          this.$notify({
            message: 'Добавлено в черный список',
            type: 'success'
          });
        } else {
          this.$notify({
            message: 'Убрано из черного списка',
            type: 'success'
          })
        }
      },

    }
  }
</script>

<style scoped>

</style>
