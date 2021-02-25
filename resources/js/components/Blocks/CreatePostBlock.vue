<template>
  <div :class="{'miniEditor': true,'miniEditor--active': editorShow}"
       class="l-island-bg l-island-round"
       v-if="user"
       v-click-outside="editorHide"
       @click="editorShowed()">
    <div class="miniEditor__full" v-if="editorShow">
      <i class="fas fa-expand-arrows-alt"></i>
    </div>
    <div class="miniEditor__avatar"  v-if="!editorShow">
      <img :src="user.avatar">
    </div>
    <div class="miniEditor__text" >
      Новая запись
    </div>

    <div class="miniEditor__editor inline-editor"  v-show="editorShow">
      <div class="editor">
        <div id="codex-editor">
        </div>
      </div>
    </div>
    <div class="attachesList andropov_uploader"></div>

    <div class="attachesList andropov_uploader">
      <div v-for="(item, index) in files" :key="item.path" class="andropov_uploader__preview_item">
        <div class="andropov_preview andropov_preview--image" style="min-height: 80px; min-width: 80px">
          <img class="andropov_preview__image" style="max-width: 80px; max-height: 80px;"
               :src="item.url">
          <div class="andropov_uploader__preview_item__remove" @click="destroy(item.path, index)"></div>
        </div>
      </div>
    </div>

    <div class="miniEditor__actions">
      <label for="file">
        <div class="attachButton">
          <ion-icon src="/icons/image-outline.svg"></ion-icon>
          <span class="attachButton__label">
          Фото и видео
        </span>
        </div>
      </label>
      <input type="file" id="file" v-on:change="upload" class="comment-file-input">
<!--      <div class="attachButton">-->
<!--        <i class="fas fa-link"></i>-->
<!--        <span class="attachButton__label">Ссылка</span>-->
<!--      </div>-->
      <div class="ui_preloader" v-if="loading">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div class="ui-button ui-button--1" :class="{'ui-button--disabled': loading}" v-show="editorShow" @click="create()">
        Опубликовать
      </div>
    </div>
  </div>
</template>

<script>
  import EditorJS from '@editorjs/editorjs';
  import {removeFromArray} from "../../helpers"
  import ClickOutside from 'vue-click-outside'
  import Header from "@editorjs/header";
  import Paragraph from "@editorjs/paragraph";
  import List from "@editorjs/list";
  import axios from "axios";

  export default {
    name: "CreatePostBlock",
    props: ['user', 'data'],
    data() {
      return {
        editorjs: {},
        editorShow: false,
        loading: false,
        file: new FormData(),
        files: []
      }
    },
    methods: {
      editorShowed() {
        this.editorShow = true;
      },
      editorHide() {
        this.editorShow = false;
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
      this.popupItem = this.$el
      this.myEditor();
    },
    directives: {
      ClickOutside
    }
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
