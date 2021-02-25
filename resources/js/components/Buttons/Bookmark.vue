<template>
  <div class="favorite_marker favorite_marker--type-content favorite_marker--non_zero"
       :class="{'favorite_marker--active' : data.is_bookmarked}"
       @click="bookmark(data.is_bookmarked ? 0 : 1)">
<!--    <i class="far fa-bookmark l-fs-20"></i>-->

    <ion-icon src="/icons/bookmark-outline.svg" v-if="!data.is_bookmarked"></ion-icon>
    <ion-icon src="/icons/bookmark.svg" v-else></ion-icon>
    <!--    <div class="favorite_marker__count">{{ data.bookmarks_count}}</div>-->
    <div class="favorite_marker__action"></div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "Bookmark",
    props: ['data'],
    methods: {
      bookmark(value) {
        if (!value) {
          axios.delete('/api/bookmark', {data: {'bookmarked': this.data.type, 'id': this.data.id}}).then((res) => {
            this.$parent.data.bookmarks_count = res.data.bookmarks
            this.$parent.data.is_bookmarked = false
          }).catch(() => {
          })
        }

        if (value) {
          axios.post('/api/bookmark', {'bookmarked': this.data.type, 'id': this.data.id}).then((res) => {
            this.$parent.data.bookmarks_count = res.data.bookmarks
            this.$parent.data.is_bookmarked = true
          }).catch(() => {
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>
