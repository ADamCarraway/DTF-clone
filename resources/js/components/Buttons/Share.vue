<template>
  <div class="content-footer__item">

  <div class="repost_button">
    <div class="repost_button__button" title="Скопировать ссылку / Поделиться">
      <i class="fas fa-share-alt l-fs-20"></i>
    </div>
  </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    name: "Share",
    props: ['data'],
    methods: {}
  }
</script>

<style scoped>

</style>
