<template>
  <el-dropdown trigger="click" @command="commands" v-if="user">
    <div class="el-dropdown-link">
      <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
    </div>
    <el-dropdown-menu slot="dropdown">
      <router-link :to="{name: 'editor', params: { data:data, postSlug:data.slug }}"
                   v-if="user.id === data.user_id" command="edit"
                   class="el-dropdown-menu__item at-dropdown-menu__item etc_control__item">
        Редактировать
      </router-link>
      <el-dropdown-item v-if="user.id === data.user_id && data.is_publish" command="unpublish"
                        class="at-dropdown-menu__item etc_control__item">
        Распубликовать
      </el-dropdown-item>
      <el-dropdown-item v-if="user.id === data.user_id" command="delete"
                        class="at-dropdown-menu__item etc_control__item">
        Удалить
      </el-dropdown-item>
      <el-dropdown-item command="edit" class="at-dropdown-menu__item etc_control__item">
        Пожаловаться
      </el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
import {mapGetters} from "vuex";
import axios from "axios";

export default {
  name: "PostManagement",
  props: ['data'],
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
  methods: {
    commands(type) {
      if (type === 'unpublish') {
        let post = this.data;
        post['is_publish'] = false;
        axios.post('/api/posts/' + this.data.id + '/unpublish', post).then((response) => {
          this.$notify({
            message: 'Материал распубликован',
            type: 'success'
          });

          this.$store.dispatch('auth/updateUser', {user: {'drafts_count': this.user.drafts_count + 1}})
        })
      }

      if (type === 'delete') {
        axios.delete('/api/posts/' + this.data.id + '/destroy').then((response) => {
          this.$notify({
            message: 'Материал удален!',
            type: 'success'
          });
        })
      }

    }
  }
}
</script>

<style scoped>

</style>
