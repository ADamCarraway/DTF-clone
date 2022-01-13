<template>
  <div class="">
    <div class="v-field--text v-field v-field--default w-100">
      <div class="v-field__wrapper">
        {{ user.role }}
        <el-select
            v-model="roles"
            @change="changeRole"
            multiple
            class="v-text-input__input">
          <el-option
              v-for="item in allRoles"
              :key="item.name"
              :label="item.name"
              :value="item.name">
          </el-option>
        </el-select>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  name: 'RoleModalUser',
  data() {
    return {
      allRoles: {},
      roles: this.user.roles == null ? [] : this.user.roles.split(',')
    }
  },
  props: ['user'],
  methods: {
    changeRole() {
      axios.post('/api/admin/users/' + this.user.id + '/change-roles', {roles: this.roles}).then((res) => {
        this.user.roles = this.roles.join(',')
        this.$notify({
          message: 'Роли изменены',
          type: 'success'
        })
      }).catch(error => {
        this.$notify({
          message: error.response.data.message,
          type: 'error',
        })
      })
    },
    getRoles() {
      axios.get('/api/admin/roles?s=' + this.s).then((res) => {
        this.allRoles = res.data
      })
    }
  },
  created() {
    this.getRoles()
  }
}
</script>
