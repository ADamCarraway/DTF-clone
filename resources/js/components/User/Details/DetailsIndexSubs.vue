<template>
  <div v-if="data" class="l-island-bg l-island-round v-island">
    <div class="v-island__header">
      <span class="v-island__title">
      Подписчики
    </span> <span class="v-island__counter">
      {{ data.total }}
    </span>
    </div>
    <div class="v-list-subsites">
      <div class="v-list-subsites__content v-list-subsites__content--columns-1">
        <div v-for="user in data.data" class="v-list-subsites-item">
          <router-link :to="{ name: 'home', params: {id: user.id} }" :key="user.id"
                       class="v-list-subsites-item__main">
            <div class="v-list-subsites-item__image"
                 lazy="loaded"
                 :style="{ backgroundImage: `url('${user.avatar}')` }"
            ></div>
            <div class="v-list-subsites-item__label">
              {{ user.name }}
            </div>
          </router-link>
          <div class="v-subscribe-button v-subscribe-button--short v-subscribe-button--state-inactive">
            <subscribe v-if="user && data.id !== user.id" :data="user" :type="'users'"></subscribe>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import {mapGetters} from "vuex";
  import Subscribe from "../../Buttons/Subscribe";

  export default {
    name: "DetailsIndexSubs",
    components: {Subscribe},
    data() {
      return {
        data: {}
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
    },
    methods: {
      getData(slug) {
        axios.get('/api/' + slug + '/details/subscribers').then((res) => {
          this.data = res.data;
          console.log(this.data)
        })
      }
    },
    created() {
      this.getData(this.$route.params.slug)
    }
  }
</script>

<style scoped>

</style>

