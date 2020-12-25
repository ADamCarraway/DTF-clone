<template>
  <div class="vote">

    <div class="vote__button l-float-left">
      <div v-if="data.is_like" @click="like(0)" class="vote__button_active">
        <i class="fas fa-heart"></i>
      </div>
      <div v-else @click="like(1)" class="">
        <i class="fas fa-heart"></i>
      </div>
    </div>

    <div class="vote__value l-float-left t-ff-1-500 l-fs-15">
      <span class="vote__value__v vote__value__v--real">{{ data.likes_count }}</span>
    </div>
  </div>

</template>

<script>
  import axios from "axios";

  export default {
    name: "Like",
    props: ['data', 'list'],
    methods: {
      like(value) {
        if (!value) {
          axios.delete('/api/like', {data: {'likeable': this.data.type, 'id': this.data.id}}).then((res) => {
            this.$parent.data.likes_count = res.data.likes
            this.$parent.data.is_like = false
          }).catch(() => {
          })
        }

        if (value) {
          axios.post('/api/like', {'likeable': this.data.type, 'id': this.data.id}).then((res) => {
            this.$parent.data.likes_count = res.data.likes
            this.$parent.data.is_like = true
          }).catch(() => {
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>
