<template>
  <div class="v-popup-fp-overlay">
    <div class="v-popup-fp-window">
      <div class="v-popup-fp-window__controls">
        <div class="v-popup-fp-window__control v-popup-fp-window__control--size">
          <ion-icon name="resize-outline" class="icon--v_maximize"></ion-icon>
        </div>
        <div class="v-popup-fp-window__control" @click="hideEditor">
          <ion-icon name="close-outline" class="icon--v_close"></ion-icon>
        </div>
      </div>
      <div class="v-popup-fp-window__body">
        <div class="editor l-island-bg" style="--scrollbar-size: 16px;">
          <div class="editor__body">

            <div class="editor__actions">
              <div class="editor-cp">
                <div class="editor-cp__content l-editor">
                  <div class="editor-cp__left">
                    <button
                        class="v-button v-button--blue v-button--size-default v-button--mobile-size-tiny v-button--disabled">
                      <span class="v-button__label"><span>Опубликовать</span></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="editor__authors">
              <div class="editor-ap">
                <div class="editor-ap__content l-editor l-flex l-fa-center">
                  <div class="editor-ap__item">
                    <el-select v-model="category" placeholder="Select" class="select-input">
                      <el-option :value="'my'" class="item" :key="'my'" :label="'Мой блог'">
                        <div class="item__image">
                          <img :src="user.avatar" lazy="loaded">
                        </div>
                        <span class="item__text">Мой блог</span>
                      </el-option>
                      <el-option
                          class="item" v-for="sub in subscriptions" :key="sub.slug" :value="sub.slug"
                          v-if="sub.type === 'category'" :label="sub.title">
                        <div class="item__image">
                          <img :src="sub.icon" lazy="loaded">
                        </div>
                        <span class="item__text">{{ sub.title }}</span>
                      </el-option>
                    </el-select>
                  </div>

                </div>
              </div>
            </div>

            <div class="editor__scrollable">
              <div class="editor__content">
                <div class="l-editor">
                  <div class="ui-limited-input ui-limited-input--big">
                    <textarea rows="1" placeholder="Заголовок"
                              maxlength="120"
                              class="editor-title"
                              style="height: 46px; overflow-y: hidden;">

                    </textarea>
                  </div>
                </div>
                <div class="editor-content">
                  <div id="codex-editor"></div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EditorJS from '@editorjs/editorjs';
import {removeFromArray} from "../../helpers"
import Header from "@editorjs/header";
import Paragraph from "@editorjs/paragraph";
import List from "@editorjs/list";
import axios from "axios";
import EventBus from "../../plugins/event-bus";
import {mapGetters} from "vuex";


export default {
  name: "CreatePostModal",
  props: ['user', 'data'],
  data() {
    return {
      editorjs: {},
      loading: false,
      file: new FormData(),
      files: [],
      category: 'my'
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
      subscriptions: 'auth/subscriptions',
    }),
  },
  methods: {
    hideEditor() {
      EventBus.$emit('editorModal', false)
    },
    myEditor: function () {
      this.editorjs = new EditorJS({
        holder: "codex-editor",
        autofocus: true,
        /**
         * This Tool will be used as default
         */
        initialBlock: "paragraph",
        tools: {
          header: {
            class: Header,
            shortcut: "CMD+SHIFT+H"
          },
          list: {
            class: List
          },
          paragraph: {
            class: Paragraph,
            config: {
              placeholder: ""
            }
          }
        },
        onReady: function () {
        },
        onChange: function () {
        }
      });
    },
    create() {
      this.loading = true;
      this.editorjs.save().then((outputData) => {
        outputData['is_publish'] = 1;
        outputData['title'] = this.title;
        outputData['id'] = this.id;

        axios.post('/api/' + this.data.slug + '/posts/store', outputData).then((response) => {
          this.loading = false;
          this.$Notify.success({
            message: 'Материал опубликован'
          });
        })
      });
    },
    upload(e) {
      this.loading = true;
      this.file.append('file', e.target.files[0]);

      axios.post('/api/file/upload', this.file)
          .then((response) => {
            this.file = new FormData();
            this.loading = false;

            this.files.push(response.data)
          })
    },
    destroy(path, index) {
      this.loading = true;

      axios.post('/api/file/destroy', {path: path})
          .then((response) => {
            this.loading = false;
            removeFromArray(this.files, index)
          })
    }
  },
  mounted: function () {
    this.myEditor();
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

.editor__body .select-input input {
  border: none!important;
  padding-left: 9px;
  color: #000;
}
</style>
