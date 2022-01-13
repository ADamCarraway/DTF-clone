<template>
  <div class="page page--entry">
    <div class="l-entry l-island-bg l-pv-30 lm-pt-15 lm-pb-30 w_1020 admin-page">
        <div class="col-6">
          {{ user.name }}

        </div>
        <div class="col-6">
          meni
        </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from "axios";

export default {
  name: "show",
  middleware: ['admin'],
  data() {
    return {
      user: []
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
  methods: {
    getUser() {
      axios.get('/api/admin/users/' + this.$route.params.id + '/show').then((res) => {
        this.user = res.data
      })
    },
  },
  created() {
    this.getUser()
  },
  metaInfo() {
    return {title: this.user.name}
  }
}
</script>

<style scoped>

</style>
