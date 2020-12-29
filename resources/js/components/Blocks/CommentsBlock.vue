<template>
  <div class='l-island-bg l-island-round l-pv-30 lm-pv-15 l-mt-15 w_1020'>
    <div class="comments comments--ready">
      <div class="comments__body">
        <div class="comments__title l-island-a l-pb-10 lm-pt-30 l-fs-18 l-fw-700 l-mb-15" data-count="0">
          <span class="comments__title__long">0&nbsp;комментариев</span>
        </div>

        <div class="comments__navigation l-island-bg ui-border--bottom l-mb-15">
          <div class="l-island-a l-height-50 l-clear">
            <div class="comments__sort l-float-left">
              <div class="ui-tabs ui-tabs--default ui-tabs--no-scroll ui-tabs--no-padding l-island-bg">
                <div class="ui-tabs__scroll">
                  <div class="ui-tabs__content ">
                    <div class="ui-tab ui-tab--active ">
                      <span class="ui-tab__label">
                        Популярные
                      </span>
                    </div>
                    <div class="ui-tab">
                      <span class="ui-tab__label">
                        По порядку
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--            comments__subscribe&#45;&#45;active-->
            <div class="comments__subscribe  l-ph-10 l-float-right">
              <i class="far fa-bell fs-24"></i>
            </div>
          </div>
        </div>

        <comment-input :postId="postId"/>

        <div class="comments__content l-island-a l-mb-30">
          <comment v-for="c in comments" :data="c" :key="c.id"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import VueTextareaAutosize  from 'vue-textarea-autosize'
  import axios from "axios";
  import Comment from "./Comment";
  import CommentInput from "./CommentInput";
  import EventBus from "../../plugins/event-bus";

  export default {
    name: "CommentsBlock",
    props: ['user', 'postId'],
    components: {CommentInput, Comment, VueTextareaAutosize},
    data() {
      return {
        comment: '',
        comments: []
      }
    },
    mounted() {
      EventBus.$on('createdComment', (data) => {
        this.comments.push(data.comment)
      });
    },
    methods: {
      getComments() {
        axios.get('/api/post/'+this.$route.params.postSlug+'/comments').then((response) => {
          this.comments = response.data;
        })
      }
    },
    created() {
      this.getComments()
    }
  }
</script>

<style>

</style>
