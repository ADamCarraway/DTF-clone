<template>
  <div class="page--index">
    <div class="l-page">
      <data-table
          :columns="columns"
          :url="url">
      </data-table>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from "axios";

export default {
  name: "index",
  middleware: ['admin'],
  data() {
    return {
      users: [],
      url: '/api/admin/users',
      columns: [
        {
          label: '#',
          name: 'id',
          orderable: true,
        },
        {
          label: 'Имя',
          name: 'name',
          orderable: true,
        },
        {
          label: 'Почта',
          name: 'email',
          orderable: true,
        },
        {
          label: 'Дата регистрации',
          name: 'created_at',
          orderable: true,
        },
        {
          label: '',
          name: 'actions',
          orderable: false,
          classes: {
            'btn': true,
            'btn-primary': true,
            'btn-sm': true,
          },
          event: "click",
          handler: this.delete,
        },
      ]
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
  methods: {
    delete(){
      alert('1')
    }
  },
  metaInfo() {
    return {title: 'Пользователи'}
  }
}
</script>

<style scoped>

</style>
