<template>
  <div class="v-popup-fp-container" :class="{'v-popup-fp-container--maximized': maximized}">
    <div class="v-popup-fp-overlay" :class="{'v-popup-fp-overlay--maximized': maximized}">
      <div class="v-popup-fp-window" :class="{'v-popup-fp-window--maximized': maximized}">
        <div class="v-popup-fp-window__controls">
          <div class="v-popup-fp-window__control v-popup-fp-window__control--size" @click="maximized = !maximized">
            <ion-icon name="resize-outline" class="icon--v_maximize" v-if="!maximized"></ion-icon>
            <ion-icon name="remove-outline" v-else></ion-icon>
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
                    <div class="editor-cp__back editor-cp-mobile">
                      <ion-icon name="arrow-back-outline"></ion-icon>
                    </div>

                    <div class="editor-cp__left">
                      <button @click="save(1, false)"
                              class="v-button v-button--blue v-button--size-default v-button--mobile-size-tiny"
                              :class="{'v-button--disabled': !title}">
                        <span class="v-button__label">
                          <span v-if="!is_publish">Опубликовать</span>
                          <span v-else>Сохранить</span>
                        </span>
                      </button>
                      <a :href="prevUrl"
                         v-if="prevUrl || is_publish"
                         target="_blank"
                         class="editor-cp-desktop v-button v-button--default v-button--size-default v-button--mobile-size-tiny v-button__icon--new"
                         title="Перейти к статье">
                        <div class="v-button__icon">
                          <ion-icon name="eye-outline"></ion-icon>
                        </div>
                      </a>

                      <div class="editor-cp__autosave editor-cp__autosave--finished" v-if="saved && !loading">
                        <span>Сохранено</span>
                        <ion-icon name="checkmark-outline"></ion-icon>
                      </div>
                      <div class="editor-cp__autosave editor-cp__autosave--finished" v-if="loading">
                        <span class="mr-1">Сохранение</span>
                        <div class="loader"></div>
                      </div>
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
                      <textarea-autosize
                          rows="1"
                          placeholder="Заголовок"
                          v-model="title"
                          :min-height="30"
                          :max-height="184"
                          maxlength="120"
                          id="editor-title"
                          class="editor-title" style="overflow-y: hidden ">
                      </textarea-autosize>
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
import Paragraph from "@editorjs/paragraph";
import AnchorBlockTune from "/public/vendor/editorjs-anchor/bundle";
import ShowInFeedTune from "/public/vendor/editorjs-showInFeed/bundle";
import EventBus from "../../plugins/event-bus";
import axios from "axios";

export default {
  name: "CreatePostModal",
  props: ['data',],
  data() {
    return {
      prevUrl: '',
      category: 'my',
      hTitle: '46px',
      title: '',
      editorjs: {},
      id: null,
      is_publish: false,
      maximized: false,
      saved: false,
      loading: false,
      time: 0,
      timeSave: 0,
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
      subscriptions: 'auth/subscriptions',
    }),
  },

  watch: {
    title: function (val) {
      if (this.data) return;

      clearTimeout(this.time)

      this.time = setTimeout(() => {
        this.save(0, true)
      }, 1300)
    },
  },
  methods: {
    hideEditor() {
      EventBus.$emit('editorShow', false)

      if (!this.is_publish && this.saved) {
        this.user.drafts_count += 1;

        this.$notify({
          message: 'Статья сохранена в черовики',
          type: 'success'
        });
      }
    },
    editor: function (data) {
      this.editorjs = new EditorJS({
        data: {
          blocks: JSON.parse(data)
        },

        holder: "codex-editor",
        autofocus: false,

        /**
         * This Tool will be used as default
         */
        initialBlock: "paragraph",
        placeholder: 'Нажмите Tab для выбора инструмента',
        tools: {
          ShowInFeed: ShowInFeedTune,
          header: {
            class: Header,
            tunes: ['ShowInFeed'],
            config: {
              placeholder: 'Заголовок',
              levels: [2, 3, 4],
              defaultLevel: 2
            }
          },
          list: {
            class: List
          },
          paragraph: {
            class: Paragraph,
            tunes: ['ShowInFeed']
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
                uploadByUrl(url) {
                  let p2 = new Promise(function (resolve, reject) {
                    resolve(1);
                  });

                  return p2.then(function (value) {
                    return {
                      success: 1,
                      file: {
                        url: url,
                      }
                    };
                  })
                }
              }
            },
            tunes: ['ShowInFeed']
          },
          link: {
            class: Link
          },
        },
        onReady: function () {
          document.getElementById("editor-title").focus();
        },
        onChange: () => {
          (async () => {
            clearTimeout(this.timeSave)

            this.timeSave = setTimeout(() => {
              this.save(0, true)
            }, 800)
          })();
        },
      });
    },
    save(publish, autoSave = false) {
      if (this.data && this.is_publish && autoSave) {
        this.editorjs.save();
        return;
      }

      this.editorjs.save().then((outputData) => {
        this.loading = true
        outputData['is_publish'] = publish;
        outputData['title'] = this.title;
        outputData['id'] = this.id;
        axios.post('/api/' + this.category + '/posts/store', outputData).then((response) => {
          this.prevUrl = '/u/' + response.data.category + '/' + response.data.post.slug
          this.loading = false
          this.saved = true
          this.id = response.data.post.id
          if (!autoSave) {
            this.is_publish = response.data.post.is_publish
          }
          if (response.data.post.is_publish && !autoSave) {
            EventBus.$emit('editorShow', false)

            this.$router.push({
              name: response.data.type,
              params: {postSlug: response.data.post.slug, slug: response.data.category}
            })
          }
        })
      }).catch((error) => {
        this.loading = false
        this.saved = false
        // console.log('Saving failed: ', error)
      });
    },
  },
  mounted: function () {
    if (this.data) {
      this.editor(this.data.blocks);

      this.title = this.data.title;
      if (this.data.category_id) {
        this.category = this.data.category.slug;
      }
      this.id = this.data.id;
      this.is_publish = this.data.is_publish;
    } else if (this.data) {
      axios.get('/api/post/' + this.data.postSlug).then((response) => {
        this.editor(response.data.blocks);

        this.title = response.data.title;
        this.category = response.data.category.slug;
        this.id = response.data.id;
        this.is_publish = response.data.is_publish;
      });
    } else {
      this.editor(null);
    }
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

.editor__body .select-input input {
  border: none !important;
  padding-left: 9px;
  color: #000;
}
</style>
