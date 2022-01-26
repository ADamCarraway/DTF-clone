<template>
  <div class="">
    <div class="v-field--text v-field v-field--default w-100">
      <form @submit.prevent="update" class="v-form-section__field">
        <div class="v-field--text v-field v-field--default w-100 mb-3" ref="inputElement" data-length="17">
          <div class="v-field__wrapper">
            <div class="v-text-input v-text-input--default">
              <input v-model="name" class="v-text-input__input" type="text" maxlength="30" name="name">
            </div>
          </div>
        </div>

        <el-transfer
            filterable
            :titles="['Доступные', 'Текущие']"
            filter-placeholder="Поиск"
            v-model="permissions"
            :data="allPermissions"
            class="d-flex justify-content-between align-items-center mb-3">
        </el-transfer>

        <button class="settings-hashtags__add-button v-button v-button--default v-button--size-default">
          <span class="v-button__label">
            <span>Изменить</span>
          </span>
        </button>
      </form>
    </div>
  </div>
</template>

<script>

import axios from "axios";
import EventBus from "../../../plugins/event-bus";

export default {
  name: 'UpdateRoleModal',
  data() {
    return {
      name: this.role.name,
      allPermissions: [],
      permissions: []
    }
  },
  watch: {
    role(role) {
      this.name = role.name
      role.permissions.forEach((role, index) => {
        this.permissions.push(role.id);
      });
    }
  },
  props: ['role'],
  methods: {
    update() {
      axios.post('/api/admin/roles/' + this.role.id +'/update', {
        name: this.name,
        permissions: this.permissions,
      }).then((res) => {
        EventBus.$emit('updatedRole', res.data)
        this.$notify({
          message: 'Роль обновлена',
          type: 'success'
        })
      })
    },
    getPermissions() {
      axios.get('/api/admin/roles/permissions').then((res) => {
        res.data.forEach((role, index) => {
          this.allPermissions.push({
            label: role.name,
            key: role.id,
          });
        });
      })
    }
  },
  created() {
    this.role.permissions.forEach((role, index) => {
      this.permissions.push(role.id);
    });
    this.getPermissions()
  }
}
</script>
