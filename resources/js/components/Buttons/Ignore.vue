<template>
  <el-dropdown trigger="click" @command="toIgnore" v-if="user && data.is_follow">
  <div class="el-dropdown-link">
   <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
  </div>
    <el-dropdown-menu slot="dropdown">
      <el-dropdown-item v-if="!data.is_ignore" command="true"
                        class="at-dropdown-menu__item etc_control__item">Игнорировать
      </el-dropdown-item>
      <el-dropdown-item v-else command="false" class="at-dropdown-menu__item etc_control__item">Не игнорировать
      </el-dropdown-item>
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
    },
    methods: {
      toIgnore(type) {
        if (type == 'true') {
          axios.post('/api/ignore', {'ignorable': this.data.type, 'id': this.data.id}).then((res) => {
            this.changeForIgnore(true);
          })
        }else {
          axios.delete('/api/ignore', {data: {'ignorable': this.data.type, 'id': this.data.id}}).then((res) => {
            this.changeForIgnore(false);
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

        this.$notify({
          message: status ? 'Добавлено в черный список' : 'Убрано из черного списка',
          type: 'success'
        });
      },

    }
  }
</script>

<style scoped>
  .el-dropdown{
    margin-right: 10px;
  }

  .el-dropdown ion-icon{
    font-size: 24px;
    vertical-align: bottom;
  }

</style>
