<template>
  <div class="page page--entry">
    <div class="l-entry l-island-bg l-island-round l-pv-30 lm-pt-15 lm-pb-30 w_1020" style="border-radius: 0px 0px 8px 8px" v-if="data.slug">
      <div class="l-entry__header l-island-a">
        <div class="content-header content-header--short">
          <div class="content-header__info l-island-a">

            <div class="content-header__left">

              <!-- Подсайт, в котором опубликована статья -->
              <router-link v-if="data.category" :to="{ name: 'category', params: {slug: data.category.slug} }"
                           class="content-header-author content-header-author--subsite content-header__item">
                <div class="content-header-author__avatar">

                  <img class="andropov_image  andropov_image--bordered"
                       :src="data.category.icon">
                </div>

                <div class="content-header-author__name">
                  {{ data.category.title }}
                </div>

              </router-link>

              <!-- Автор -->
              <router-link v-if="data.user" :to="{ name: 'user', params: {slug: data.user.slug} }"
                           class="content-header-author content-header__item" :class="{'content-header-author--subsite': !data.category}">
                <div v-if="!data.category" class="content-header-author__avatar">

                  <img class="andropov_image  andropov_image--bordered"
                       :src="data.user.avatar">
                </div>

                <div class="content-header-author__name">
                  {{ data.user.name }}
                </div>

              </router-link>

              <!-- Время публикации -->
              <div class="content-header-number content-header__item">
                <span class="time">{{ data.date }}</span>
              </div>

              <!-- Число просмотров -->
              <div class="content-header-number content-header__item">
                <ion-icon src="/icons/eye-outline.svg" :class="'mr-2'"></ion-icon> {{ data.unique_views_count }}
              </div>

              <!-- Закрепленный пост -->

              <!-- Пометка у спонсорских постов -->

            </div>

            <div class="content-header__right">
              <!-- Бейдж черновика -->

              <!-- Управление статьей -->

              <div class="etc_control">
                <svg class="icon icon--ui_etc" width="18" height="8" xmlns="http://www.w3.org/2000/svg">
                  <use xlink:href="#ui_etc"></use>
                </svg>
              </div>

              <!-- Кнопка «Подписаться» -->
            </div>

          </div>

          <h1 class="content-title" itemprop="headline">
            {{ data.title }}
          </h1>

        </div>
      </div>

      <div class="l-entry__content">
        <div class="content content--full" v-html="html"></div>
        <post-footer :data="data"/>
      </div>

      <div class="subsite-card-entry">
        <div class="subsite-card-entry--short">
          <div class="subsite-card">
            <router-link router-link :to="{ name: 'user', params: {slug: data.user.slug} }" class="subsite-card__main">
              <!-- Автор -->
              <div class="subsite-card__avatar" :style="{ backgroundImage: `url('${data.user.avatar}')` }"></div>

              <div class="subsite-card-title">
                <span class="subsite-card-title__item subsite-card-title__item--name">
                {{ data.user.name }}
                </span>
              </div>
            </router-link>

            <div class="subsite-card__actions">
              <div v-if="!data.user.id" class="preloader preloader-actions"></div>
              <div v-else
                   class="v-subscribe-button v-subscribe-button--full v-subscribe-button--with-notifications v-subscribe-button--state-active">
                <subscribe v-if="user && data.user.id !== user.id" :data="data.user" :type="data.user.type"></subscribe>
                <notification :data="data.user" :type="'users'"></notification>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <comments-block :data="data" :user="user" :count="data.comments_count" />
  </div>
</template>

<script>
  import axios from "axios";
  import edjsHTML from "editorjs-html";
  import Like from "../components/Buttons/Like";
  import Bookmark from "../components/Buttons/Bookmark";
  import Subscribe from "../components/Buttons/Subscribe";
  import Notification from "../components/Buttons/Notification";
  import {mapGetters} from "vuex";
  import moment from "moment";
  import PostFooter from "../components/Blocks/PostFooter";
  import CommentsBlock from "../components/Blocks/CommentsBlock";
  import Comment from "../components/Blocks/Comment";

  export default {
    name: "post",
    components: {CommentsBlock, Comment, PostFooter, Subscribe, Bookmark, Like, Notification},
    data() {
      return {
        data: {},
        html: '',
        title: '',
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user',
      }),
    },
    methods: {
      getPost() {
        axios.get('/api/post/' + this.$route.params.postSlug).then((response) => {
          this.data = response.data;
          let test = new edjsHTML()
          let html = test.parse({
            blocks: JSON.parse(response.data.blocks)
          });

          for (let i in html){
            this.html  += html[i];
          }
        });
      },
    },
    created() {
      this.getPost();
    },
    metaInfo() {
      return {title: this.data.title !== '' ? this.data.title : 'Запись пользователя '+ this.data.user.name}
    }
  }
</script>

<style scoped>

  .content-header--short {
    padding-top: 0px;
    margin-bottom: 0px;
  }

  .content-header__info.l-island-a {
    padding-left: 0;
    padding-right: 0;
  }

  .content-footer--short {

    margin-left: auto;
    margin-right: auto;
  }

  .content--full {

    margin-left: auto;
    margin-right: auto;
  }

  .l-entry__header {

    padding-left: 0;
    padding-right: 0;
  }

  .content-footer--short {
    padding: 0;
    margin-top: 30px;
  }

  .subsite-card-entry--short{

    margin-left: auto;
    margin-right: auto;
  }

  .subsite-card {
    --avatar-size: 40px;
    font-size: 16px;
    line-height: 1.5em;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
  }

  .subsite-card {
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
  }

  @media (min-width: 860px){
    .subsite-card__main {
      min-height: 49px;
    }
  }
   .subsite-card__main {
     display: grid;
     -ms-flex-align: center;
     align-items: center;
     grid-template-columns: var(--avatar-size) 1fr;
     grid-template-rows: 1fr auto;
     grid-gap: 0 12px;
     -ms-flex: 1;
     flex: 1;
     min-height: 36px;
   }

  .subsite-card__avatar {
    grid-row: span 2;
    width: var(--avatar-size);
    padding-bottom: 100%;
    -webkit-box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    border-radius: 7px;
    margin-top: -1px;
  }

  .subsite-card-title__item--name {
    font-size: 18px;
    line-height: 1.44em;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    -ms-flex-negative: 1;
    flex-shrink: 1;
  }

  .content.content--full p{
    margin-top: 0px;
    margin-bottom: 15px;
  }

  .content-header__info{
    margin-bottom: 0px;
  }
</style>
