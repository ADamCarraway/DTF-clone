<template>
  <div @click="ban(!user.is_banned)">
    <span v-if="user.is_banned" >Разбанить</span>
    <span v-else >Забанить</span>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: 'BanUser',

  props: ['user'],
  methods: {
    ban(status) {
      axios.post('/api/admin/users/' + this.user.id + '/ban', {status: status}).then((res) => {
        this.user.is_banned = status
        this.$notify({
          message: !status ? 'Аккаунт разблокирован' : 'Аккаунт заблокирован',
          type: 'success'
        })
      }).catch(error => {
        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
  }
}
</script>
