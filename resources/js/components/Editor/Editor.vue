<template>
  <div class="page page--editor">
    <div class="wrapper l-island-bg">
      <div class="header">
        <div class="header__content l-editor l-flex l-fa-center">
          <div class="header__left">
            <div class="tabs l-flex l-fa-center"></div>
          </div>
          <div class="header__right l-flex l-fa-center">
            <div class="ui-button ui-button--5" @click="save(1)">
              Опубликовать
            </div>
            <div title="Сохранить" class="ui-button ui-button--1 ui-button--only-icon" @click="save(0)">
              <i class="far fa-save"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="l-editor">
        <div class="subheader l-flex l-fa-center">
          <div class="subheader__item">
            <at-select v-model="category" size="large" style="width: 190px">
              <at-option :value="'my'" class="item" :key="'my'" :label="'Мой блог'">
                <div class="item__image">
                  <img :src="user.avatar" lazy="loaded">
                </div>
                <span class="item__text">Мой блог</span>
              </at-option>
              <at-option class="item" v-for="sub in subscriptions" :key="sub.slug" :value="sub.slug"
                         v-if="sub.type === 'category'" :label="sub.title">
                <div class="item__image">
                  <img :src="sub.icon" lazy="loaded">
                </div>
                <span class="item__text">{{ sub.title }}</span>
              </at-option>
            </at-select>
          </div>
          <div class="subheader__item">
            <div class="select select--disabled">
              <div class="select__current">
                <span class="select__image"><img :src="user.avatar" alt=""></span>
                <span class="select__label">{{ user.name }}</span>
              </div>
            </div>
          </div>
          <div class="subheader__item">
            <div class="date">
              {{ now }}
            </div>
          </div>
        </div>
        <div class="ui-limited-input ui-limited-input--big" data-length="120">
          <textarea
            rows="1"
            placeholder="Заголовок"
            default="default"
            maxlength="120"
            class="writing-title"
            style="height: 46px; overflow-y: hidden;"
            :style="{ height: hTitle }"
            v-model="title"></textarea>
        </div>
      </div>
      <div class="editor">
        <div id="codex-editor">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import moment from 'moment'
  import EditorJS from "@editorjs/editorjs";
  import Header from "@editorjs/header";
  import List from "@editorjs/list";
  import Delimiter from "@editorjs/delimiter";
  import Image from "@editorjs/image";
  import Link from "@editorjs/link";
  import Cover from "./IndicatorCover/index"
  import Paragraph from "@editorjs/paragraph";
  import EventBus from "../../plugins/event-bus";
  import axios from "axios";

  export default {
    name: "CodexEditor",
    data() {
      return {
        category: 'my',
        hTitle: '46px',
        title: '',
        editorjs: {},
        id: null
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
        subscriptions: 'auth/subscriptions',
      }),
      now: function () {
        return moment().locale("ru").format('DD MMM [в] H:mm');
      },
    },
    watch: {
      title: function (val) {
        // if(val.length % 47 === 0 )
      },
    },
    methods: {
      editor: function () {
        let t = this;
        let cover = {};
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
            },
            list: {
              class: List
            },
            paragraph: {
              class: Paragraph,
            },
            delimiter: {
              class: Delimiter
            },
            image: {
              class: Image,
              config: {
                uploader: {
                  uploadByFile(file) {
                    let formData = new FormData();
                    formData.append('file', file);

                    return axios.post('/api/file/upload', formData)
                      .then((response) => {
                        return {
                          success: 1,
                          file: {
                            url: response.data.url,
                          }
                        };
                      });
                  },
                }
              }
            },
            link: {
              class: Link
            },
          },
          onReady: function () {

          },
          onChange: function () {
          }
        });
      },
      save(publish) {
        this.editorjs.save().then((outputData) => {
          outputData['is_publish'] = publish;
          outputData['title'] = this.title;
          outputData['id'] = this.id;
          axios.post('/api/' + this.category + '/posts/store', outputData).then((response) => {
            this.id = response.data.post.id
            if (response.data.post.is_publish) {
              this.$router.push({
                name: response.data.type,
                params: {postSlug: response.data.post.slug, slug: response.data.category}
              })
            }
          })
        }).catch((error) => {
          console.log('Saving failed: ', error)
        });
        ;
      },
    },
    mounted: function () {
      // EventBus.$emit('hideSidebar');
      // EventBus.$emit('hideLive');
      this.editor();
    },
  }
</script>

<style scoped>
  .live {
    opacity: 0;
    pointer-events: none;
  }

  @media (min-width: 840px) {
    .layout__right-column {
      width: 0 !important;
      overflow: hidden;
    }

    .layout__spacer--right {
      width: calc((100% - 920px) * 0.5);
    }
  }

  .wrapper {
    min-height: calc(100vh - 60px);
    padding-bottom: 40px;
  }

  .header {
    position: sticky;
    top: 60px;
    background-color: #fff;
    margin-bottom: 40px;
    z-index: 19;
    font-size: 14px;
    line-height: 1.45em;
    -webkit-box-shadow: 0 6px 17px -2px rgba(0, 0, 0, 0.02), 0 2px 2px -1px rgba(0, 0, 0, 0.04);
    box-shadow: 0 6px 17px -2px rgba(0, 0, 0, 0.02), 0 2px 2px -1px rgba(0, 0, 0, 0.04);
  }

  .header__content {
    height: 50px;
    position: relative;
  }

  @media (min-width: 860px) {
    .header__left {
      margin-right: 20px;
    }
  }

  .header__left {
    min-width: 0;
    margin-right: 10px;
  }

  .tabs {
    display: -ms-flexbox;
    display: flex;
  }

  .header__right {
    margin-left: auto;
  }

  .header__right .ui-button:not(:last-child) {
    margin-right: 10px;
  }

  .header__right .ui-button {
    -ms-flex-negative: 0;
    flex-shrink: 0;
  }

  .subheader {
    font-size: 15px;
    line-height: 20px;
    margin-bottom: 12px;
    position: relative;
    z-index: 2;
  }

  .subheader__item:not(:last-child) {
    margin-right: 25px;
  }

  .subheader__item {
    min-width: 0;
    -ms-flex-negative: 1;
    flex-shrink: 1;
  }

  .writing-title {
    display: block;
    width: 100%;
    height: 47px;
    margin: 0 0 12px;
    padding: 0;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    resize: none;
    border: 0;
    outline: 0 !important;
    font-size: 36px;
    line-height: 1.3em;
    font-weight: 500;
  }

  .item {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    height: 36px;
    padding-left: 12px;
    line-height: 36px;
    cursor: pointer;
    color: #000;
    overflow: hidden;
  }

  .item__image {
    width: 20px;
    height: 20px;
    border-radius: 2px;
    margin-right: 10px;
    background-color: #fff;
    -ms-flex-negative: 0;
    flex-shrink: 0;
  }

  .item__image img {
    display: block;
    width: 100%;
    height: 100%;
    border-radius: 2px;
    outline: 1px solid rgba(0, 0, 0, 0.1);
    outline-offset: -1px;
  }

  .item:first-child span {
    border-top-color: transparent;
  }

  .item--selected span, .item--focused span, .item:hover span {
    border-top-color: transparent;
  }

  .item span {
    -ms-flex-positive: 1;
    flex-grow: 1;
    border-top: 1px solid rgba(0, 0, 0, 0.07);
    margin-left: 2px;
  }

  .item__text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-right: 10px;
  }

  .at-select__selection {
    background: #000 !important;
  }

  .editor {
    font-size: 18px;
    position: relative;
    z-index: 1;
  }

  .select--disabled {
    pointer-events: none;
  }

  .select {
    white-space: nowrap;
    line-height: 20px;
    position: relative;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  .select__current {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    cursor: pointer;
  }

  .select__image {
    width: 20px;
    height: 20px;
    border-radius: 2px;
    overflow: hidden;
    margin-right: 12px;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    background-color: #ccc;
  }

  .select__image img {
    width: 100%;
    height: 100%;
    outline: 1px solid rgba(0, 0, 0, 0.1);
    outline-offset: -1px;
  }

  .select__label {
    -ms-flex-negative: 1;
    flex-shrink: 1;
    min-width: 20px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .at-select__dropdown--bottom {
    width: auto !important;
  }
</style>
