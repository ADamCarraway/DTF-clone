<template>
  <codex-editor/>
</template>

<script>
  import CodexEditor from "../../components/Editor/Editor";

  export default {
    name: "editor",
    components: {CodexEditor},
    middleware: 'auth',
    metaInfo() {
      return {title: '✍️ Написание статьи'}
    }
  }
</script>

<style scoped>

</style>
