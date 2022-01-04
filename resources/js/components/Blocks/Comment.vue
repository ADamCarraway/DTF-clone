<template>
  <div class="comments__item">
    <div class="comments__item__space">
      <div class="comments__item__self comments__item__self--author comments__item__self--major">
        <div class="comments__item__header">
          <div class="comments__item__users">

            <!-- User -->
            <router-link v-if="data.user" :to="{ name: 'user', params: {slug: data.user.slug} }"
                         class="comments__item__user t-link">
              <img class="andropov_image comments__item__user__image andropov_image--bordered"
                   style="background-color: transparent;"
                   :src="data.user.avatar">
              <p class="comments__item__user__name">
                <span class="user_name">{{ data.user.name }}</span>
              </p>
            </router-link>

            <a href="https://dtf.ru/u/91342-adam-carraway/285557-yted?comment=8485319" v-if="parent"
               class="comments__item__replied_to t-link">
              <ion-icon name="return-up-back-outline"></ion-icon>
              {{ parent.user.name }}
            </a>

          </div>


          <!-- Rows separator -->
          <div class="comments__item__sep"></div>

          <!-- Date -->
          <div class="comments__item__date t-link">
            <time class="time">{{ data.date }}</time>
          </div>
        </div>


<!--        <div class="vote vote&#45;&#45;comment">-->
<!--          <div class="vote__button vote__button&#45;&#45;minus">-->
<!--            <svg class="icon icon&#45;&#45;ui_arrow_down" width="14" height="12" xmlns="http://www.w3.org/2000/svg">-->
<!--              <use xlink:href="#ui_arrow_down"></use>-->
<!--            </svg>-->
<!--            <div class="vote__button__action"></div>-->
<!--          </div>-->

<!--          <div class="vote__value t-ff-1-500 l-fs-16">-->
<!--            <span class="vote__value__v vote__value__v&#45;&#45;real">0</span>-->
<!--          </div>-->

<!--          <div class="vote__button vote__button&#45;&#45;plus">-->
<!--            <svg class="icon icon&#45;&#45;ui_arrow_up" width="14" height="12" xmlns="http://www.w3.org/2000/svg">-->
<!--              <use xlink:href="#ui_arrow_up"></use>-->
<!--            </svg>-->
<!--            <div class="vote__button__action"></div>-->
<!--          </div>-->

<!--        </div>-->


        <!-- Content -->
        <div class="comments__item__content">

          <div class="comments__item__text"><p>{{ data.comment }}</p></div>

          <!-- Display donate value -->

        </div>
        <!-- Reply -->
        <div class="comments__item__reply" @click="toggle">
          <ion-icon name="chatbubble-outline" style="transform: scale(-1, 1);"></ion-icon> Ответить</div>

        <bookmark :data="data"/>

        <like :data="data" class="comments__item__like"/>

        <!-- Admin -->
        <!--        <div class="etc_control" air-module="module.etc_controls" >-->
        <!--          <svg class="icon icon&#45;&#45;ui_etc" width="14" height="7" xmlns="http://www.w3.org/2000/svg">-->
        <!--            <use xlink:href="#ui_etc"></use>-->
        <!--          </svg>-->
        <!--        </div>-->
      </div>
    </div>
    <div class="comments__item__other" v-if="!type || type !== 'userComments'">

      <comment-input :postId="data.commentable_id" :parent="data" v-if="show" :show="true" :type="'reply'"/>

      <!-- Children comments -->
      <div :class="{'comments__item__children': !parent}" v-show="repliesShow">
        <comment v-for="c in data.replies" :data="c" :parent="data" :key="c.id"/>
      </div>
      <!-- Collapse subtree stripe -->
      <div class="comments__item__collapse_subtree" v-if="repliesShow && !parent" @click="repliesShow = false"></div>

      <div class="comments__item__more comments__item__more--inner" v-if="!repliesShow">
        <!--        <div class="comments__item__more__avatars">-->
        <!--          <img class="andropov_image comments__item__more__avatar">-->
        <!--        </div>-->
        <span class="comments__item__more__text">
          <span class="comments__item__more__count"
                @click="repliesShow = true">Развернуть ветку</span>
        </span>
      </div>

    </div>
  </div>
</template>

<script>
  import CommentInput from "./CommentInput";
  import EventBus from "../../plugins/event-bus";
  import Vue from 'vue'
  import Like from "../Buttons/Like";
  import Bookmark from "../Buttons/Bookmark";

  const xxx = Vue.observable({active: null});
  let id = 0;

  export default {
    name: "Comment",
    components: {Bookmark, Like, CommentInput},
    props: ['data', 'parent', 'type'],
    data() {
      return {
        repliesShow: true,
        replyFormShow: false,
        id: ++id,
      }
    },
    mounted() {
      EventBus.$on('hideReplyForm', () => {
        xxx.active = null
      });
    },
    computed: {
      show() {
        return xxx.active === this.id;
      },
    },
    methods: {
      toggle() {
        xxx.active = this.show ? null : this.id;
      },
    },
  }
</script>

<style scoped>

</style>
