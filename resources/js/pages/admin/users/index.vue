<template>
  <div class="page page--entry">
    <div class="l-island-bg l-island-a l-pv-30 lm-pt-15 lm-pb-30 w_1020 admin-page">
      <div class="l-page">
        <div class="subsite_head__row">
          <div class="subsite_head__name l-fs-30 lm-fs-22 l-lh-30 l-fw-600">
            Пользователи сайта
          </div>
        </div>
        <el-table
            :data="users"
            :default-sort="{prop: 'id', order: 'descending'}"
            @sort-change="handleSort"
            style="width: 100%">
          <el-table-column
              prop="name"
              label="Имя"
              sortable="custom">
            <template slot-scope="scope">
              <b>{{ scope.row.name }}</b>
            </template>
          </el-table-column>
          <el-table-column
              prop="role"
              label="Роль">
            <template slot-scope="scope">
              <el-tag size="small" type="success" v-if="scope.row.roles"
                      v-for="role in (scope.row.roles == null ? '' : scope.row.roles).split(',')" :key="role">{{ role }}
              </el-tag>
              <el-tag type="info" size="small" v-else>юзер</el-tag>
            </template>
          </el-table-column>
          <el-table-column
              prop="email"
              label="Почта"
              sortable="custom">
          </el-table-column>
          <el-table-column
              prop="date"
              label="Рега"
              sortable="custom">
          </el-table-column>
          <el-table-column
              align="right">
            <template slot="header" slot-scope="scope">
              <el-input
                  v-model="s"
                  size="mini"
                  placeholder="Поиск"/>
            </template>
            <template slot-scope="scope">
              <el-button
                  size="mini"
                  class="ml-2"
                  @click="$router.push({ name: 'admin.users.show', params: {id: scope.row.id} })">
                <ion-icon name="eye-outline"></ion-icon>
              </el-button>
              <el-dropdown trigger="click" v-if="user">
                <el-button size="mini">
                  <ion-icon name="ellipsis-horizontal"></ion-icon>
                </el-button>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item
                      class="el-dropdown-menu__item at-dropdown-menu__item etc_control__item">
                    <span @click="changeRole(scope.row)">Роли</span>
                  </el-dropdown-item>
                  <el-dropdown-item class="el-dropdown-menu__item at-dropdown-menu__item etc_control__item">
                    <ban-user :user="scope.row"/>
                  </el-dropdown-item>
                  <el-dropdown-item class="el-dropdown-menu__item at-dropdown-menu__item etc_control__item text-danger">
                    <delete-user :user="scope.row"/>
                  </el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>

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
      </div>
      <el-dialog
          title="Редактировать роли"
          :modal="false"
          :visible.sync="roleModalVisible"
          width="40%">
        <role-modal-user :user="selectedUser"/>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import Delete from '../../../components/Admin/User/Delete'
import axios from "axios";
import BanUser from "../../../components/Admin/User/Ban";
import DeleteUser from "../../../components/Admin/User/Delete";
import RoleModalUser from "../../../components/Admin/User/RoleModal";

export default {
  name: "index",
  middleware: ['admin'],
  components: {RoleModalUser, DeleteUser, BanUser, Delete},
  data() {
    return {
      users: [],
      total: 0,
      perPage: 15,
      currentPage: 1,
      s: '',
      sortProp: 'id',
      sortOrder: 'descending',
      roleModalVisible: false,
      selectedUser: []
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
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
    changeRole(user) {
      this.selectedUser = user
      this.roleModalVisible = true;
    },
    getData() {
      axios.get('/api/admin/users?count=' + this.perPage + '&page=' + this.currentPage + '&order=' + this.sortOrder + '&orderBy=' + this.sortProp + '&s=' + this.s).then((res) => {
        this.users = res.data.data
        this.total = Number(res.data.total)
        this.perPage = Number(res.data.per_page)
        this.currentPage = Number(res.data.current_page)
      })
    },
  },
  created() {
    this.getData()
  },
  metaInfo() {
    return {title: 'Пользователи'}
  }
}
</script>

<style scoped>
.el-tag + .el-tag {
  margin-left: 3px;
}
</style>
