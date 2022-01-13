<template>
  <span  @click="destroy">Удалить</span>
</template>

<script>

import axios from "axios";

export default {
  name: 'DeleteUser',

  props: ['user'],
  methods: {
    destroy() {
      axios.get('/api/admin/users/' + this.user.id + '/destroy').then((res) => {
        this.user = {}
        this.$notify({
          message: 'Аккаунт удален',
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
