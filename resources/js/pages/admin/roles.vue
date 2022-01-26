<template>
  <div class="page page--entry">
    <div class="l-island-bg l-island-a l-pv-30 lm-pt-15 lm-pb-30 w_1020 admin-page">
      <div class="l-page">
        <div class="subsite_head__row">
          <div class="subsite_head__name l-fs-30 lm-fs-22 l-lh-30 l-fw-600">
            Роли
          </div>
        </div>
        <div class="w-25" v-if="user.all_permissions.includes('create role')">
          <el-button @click="createRoleModalVisible = !createRoleModalVisible">Создать роль</el-button>
        </div>
        <el-table
            :data="roles"
            :default-sort="{prop: 'id', order: 'descending'}"
            @sort-change="handleSort"
            style="width: 100%">
          <el-table-column
              width="75"
              label="Права"
              type="expand">
            <template slot-scope="props">
              <el-tag effect="plain" v-for="(item, index) in props.row.permissions" :key="item.id" closable
                      @close="removePermission(props.row.id, item.id, props.row)">{{ item.name }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column
              prop="name"
              label="Название"
              sortable="custom">
          </el-table-column>
          <el-table-column
              prop="users_count"
              label="Юзеров">
          </el-table-column>
          <el-table-column align="right" width="200">
            <template slot="header" slot-scope="scope">
              <el-input
                  size="mini"
                  v-model="s"
                  placeholder="Поиск"/>
            </template>
            <template slot-scope="scope">
              <el-button
                  v-if="user.all_permissions.includes('update role')"
                  size="mini"
                  @click="selectRole = scope.row; roleModalVisible = true">
                <ion-icon name="settings-outline"></ion-icon>
              </el-button>
              <el-popconfirm
                  v-if="user.all_permissions.includes('delete role')"
                  @confirm="deleteRole(scope.row,scope.$index)"
                  title="Действительно удалить?">
                <el-button
                    size="mini"
                    class="ml-2"
                    slot="reference">
                  <ion-icon name="trash-outline"></ion-icon>
                </el-button>
              </el-popconfirm>
            </template>
          </el-table-column>
        </el-table>
        <el-pagination
            background
            layout="total, prev, pager, next, sizes"
            :total="total"
            :page-size="perPage"
            :current-page="currentPage"
            :page-sizes="[15,25,50,100]"
            @current-change="handleCurrentChange"
            @size-change="handleSizeChange">
        </el-pagination>

        <el-dialog
            title="Редактирование роли"
            :modal="false"
            :visible.sync="roleModalVisible"
            width="50%">
          <update-role-modal :role="selectRole"/>
        </el-dialog>
        <el-dialog
            title="Создание роли"
            :modal="false"
            :visible.sync="createRoleModalVisible"
            width="50%">
          <create-role-modal/>
        </el-dialog>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from "axios";
import UpdateRoleModal from "../../components/Admin/Role/UpdateRoleModal";
import CreateRoleModal from "../../components/Admin/Role/CreateRoleModal";
import EventBus from "../../plugins/event-bus";

export default {
  name: "roles",
  components: {CreateRoleModal, UpdateRoleModal},
  middleware: ['admin'],
  data() {
    return {
      createRoleModalVisible: false,
      roleModalVisible: false,
      selectRole: {},
      roles: [],
      total: 0,
      perPage: 15,
      currentPage: 1,
      s: '',
      sortProp: 'id',
      sortOrder: 'descending',
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
  mounted() {
    let t = this
    EventBus.$on('createdRole', function (data) {
      t.createRoleModalVisible = false
      t.roles.push(data);
    })
    EventBus.$on('updatedRole', function (data) {
      t.roleModalVisible = false
      t.roles.forEach((role, index) => {
        if (role.id === data.id){
          t.roles[index] = data
        }
      });
    })
  },
  watch: {
    s(val) {
      this.getData()
    }
  },
  methods: {
    handleSizeChange(val) {
      this.perPage = val
      this.getData()
    },
    handleCurrentChange(val) {
      this.currentPage = val
      this.getData()
    },
    handleSort(column) {
      this.sortProp = column.prop
      this.sortOrder = column.order
      this.getData()
    },
    getData() {
      axios.post('/api/admin/roles-index', {
        count: this.perPage,
        page: this.currentPage,
        order: this.sortOrder,
        orderBy: this.sortProp,
        s: this.s,
      }).then((res) => {
        this.roles = res.data.data
        this.total = Number(res.data.total)
        this.perPage = Number(res.data.per_page)
        this.currentPage = Number(res.data.current_page)
      })
    },
    removePermission(role, permission, row) {
      if (!this.user.all_permissions.includes('detach permission'))return;

      axios.get('/api/admin/roles/' + role + '/' + permission + '/detach').then((res) => {
        row.permissions = res.data.permissions
      })
    },
    deleteRole(role, index) {
      axios.delete('/api/admin/roles/' + role.id).then((res) => {
        this.roles.splice(index,1)
        this.$notify({
          message: 'Роль удалена',
          type: 'success'
        })
      })
    }
  },
  created() {
    this.getData()
  },
  metaInfo() {
    return {title: 'Роли'}
  }
}
</script>

<style scoped>
.el-tag + .el-tag {
  margin-left: 3px;
}
</style>
