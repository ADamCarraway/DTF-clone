<template>
  <div class="">
    <div class="miniEditor l-island-bg l-island-round" @click="editorShowed()">
      <div class="miniEditor__avatar">
        <img :src="user.avatar">
      </div>
      <div class="miniEditor__text">
        Новая запись
      </div>

      <div class="attachesList andropov_uploader"></div>

      <div class="miniEditor__actions">
        <div class="attachButton">
          <ion-icon name="image-outline"></ion-icon>
          <span class="attachButton__label">
          Фото и видео
        </span>
        </div>
        <div class="attachButton">
          <ion-icon name="link-outline" style="color:#27e"></ion-icon>
          <span class="attachButton__label">
          Ссылка
        </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CreatePostModal from "./CreatePostModal";
import EventBus from "../../plugins/event-bus";
import {mapGetters} from "vuex";

export default {
  name: "CreatePostBlock",
  components: {CreatePostModal},
  data() {
    return {
      editorShow: false,
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },

  methods: {
    editorShowed() {
      EventBus.$emit('editorShow', true)
    },
  },
}
</script>

<style>
.miniEditor__editor .codex-editor__redactor {
  max-width: 680px;
  padding-bottom: 143px !important;
}

.miniEditor__editor .ce-toolbar__actions {
  display: none;
}

</style>
