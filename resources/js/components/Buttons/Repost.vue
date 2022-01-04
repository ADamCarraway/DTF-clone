<template>
  <div class="content-footer__item">
    <div class="repost_button">
      <div class="repost_button__button"
           :class="{'repost_button__button--active': data.is_reposted}"
           title="Сделать репост"
           @click="repost(data.is_reposted)"
      >
<!--        <i class="fas fa-retweet l-fs-20"></i>-->
        <ion-icon name="sync-outline"></ion-icon>
        <div class="repost_button__counter l-ml-4" v-if="data.repost_count > 0">{{ data.repost_count }}</div>
        <div class="repost_button__counter l-ml-4"></div>
      </div>
      <div class="repost_button__list"></div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "Repost",
    props: ['data'],
    data() {
      return {}
    },
    methods: {
      repost(value) {
        if (value) {
          axios.delete('/api/repost/' + this.data.id, {}).then((res) => {
            this.$parent.data.is_reposted = false
            this.$parent.data.repost_count = this.$parent.data.repost_count - 1

            this.$notify({
              message: 'Запись распубликована из вашего блога',
              type: 'success'
            })
          }).catch(() => {
          })
        }

        if (!value) {
          axios.post('/api/repost/' + this.data.id, {}).then((res) => {
            this.$parent.data.is_reposted = true
            this.$parent.data.repost_count = res.data + 1

            this.$notify({
              message: 'Запись была опубликована в ваш блог',
              type: 'success'
            })
          }).catch(() => {
          })
        }
      },
    }
  }
</script>

<style scoped>

</style>
