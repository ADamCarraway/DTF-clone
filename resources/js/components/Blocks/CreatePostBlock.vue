<template>
  <div :class="{'miniEditor': true,'miniEditor--active': editorShow}" class="l-island-a l-island-bg l-island-round"
       @click="editorShowed()">
    <div class="miniEditor__full" v-if="editorShow">
      <i class="fas fa-expand-arrows-alt"></i>
    </div>
    <div class="miniEditor__avatar" v-if="!editorShow">
      <img src="https://leonardo.osnova.io/d0899f05-8489-abde-8cfc-60986c29cb96/-/scale_crop/64x64/center/">
    </div>
    <div class="miniEditor__text">
      Новая запись
    </div>

    <div class="miniEditor__editor inline-editor" v-show="editorShow">
      <div class="editor">
        <div id="codex-editor">
        </div>
      </div>
    </div>
    <div class="attachesList andropov_uploader"></div>
    <div class="miniEditor__actions">
      <div class="attachButton">
        <i class="far fa-image"></i>
        <span class="attachButton__label">Фото и видео</span>
      </div>
      <div class="attachButton">
        <i class="fas fa-link"></i>
        <span class="attachButton__label">Ссылка</span>
      </div>
      <span class="ui_preloader" style="display: none;">
        <span class="ui_preloader__dot"></span>
        <span class="ui_preloader__dot"></span>
        <span class="ui_preloader__dot"></span>
      </span>
      <div class="ui-button ui-button--1" v-show="editorShow">
        Опубликовать
      </div>
    </div>
  </div>
</template>

<script>
  import EditorJS from '@editorjs/editorjs';

  import Header from "@editorjs/header";
  import Paragraph from "@editorjs/paragraph";
  import List from "@editorjs/list";

  export default {
    name: "CreatePostBlock",
    props: ['data'],
    data() {
      return {
        editorShow: false
      }
    },
    methods: {
      editorShowed() {
        this.editorShow = true;
      },
      myEditor: function () {
        window.editor = new EditorJS({
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
            console.log("ready");
          },
          onChange: function () {
            console.log("change");
          }
        });
      }
    },
    mounted: function () {
      this.myEditor();
    }
  }
</script>

<style>
  .miniEditor--active .ce-block:first-child {
    margin-right: 35px;
  }

  .codex-editor__redactor {
    max-width: 680px;
    padding-bottom: 143px !important;
  }

</style>
