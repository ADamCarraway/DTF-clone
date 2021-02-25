<template>
    <div v-if="data.is_favorite" @click="toFavorite(0,data.slug, data.type)"
         class="sidebar-tree-list-item__favourite sidebar-tree-list-item__favourite--active">
      <ion-icon src="/icons/lock-closed-outline.svg"></ion-icon>
    </div>
    <div v-else @click="toFavorite(1,data.slug, data.type)"
         class="sidebar-tree-list-item__favourite">
      <ion-icon src="/icons/lock-open-outline.svg"></ion-icon>
    </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "Favorite",
    props: ['data'],
    methods: {
      toFavorite(value, slug, type) {
        if (!value) {
          axios.delete('/api/' + slug + '/' + type + '/favorite/destroy', {data: {'followable': this.data.type, 'id': this.data.id}}).then((res) => {
            this.$store.dispatch('auth/changeSubscriptionField', {
              slug: slug,
              key: 'is_favorite',
              value: 0
            });
          }).catch(() => {
          })
        }

        if (value) {
            axios.post('/api/' + slug + '/' + type + '/favorite/store', { 'followable': this.data.type, 'id': this.data.id}).then((res) => {
              this.$store.dispatch('auth/changeSubscriptionField', {
              slug: slug,
              key: 'is_favorite',
              value: 1
            });
          }).catch(() => {
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>
