<template>
  <div class='l-island-bg l-island-round l-pv-30 lm-pv-15 l-mt-15 w_1020 '>
    <div class="comments comments--ready">
      <div class="comments__body">
        <div class="comments__title l-island-a l-pb-10 lm-pt-30 l-fs-18 l-fw-700 l-mb-15" data-count="0">
          <span class="comments__title__long">{{ count }} комментариев</span>
        </div>

        <div class="comments__navigation l-island-bg ui-border--bottom l-mb-15">
          <div class="l-island-a l-height-50 l-clear">
            <div class="comments__sort l-float-left">
              <div class="ui-tabs ui-tabs--default ui-tabs--no-scroll ui-tabs--no-padding l-island-bg">
                <div class="ui-tabs__scroll">
                  <div class="ui-tabs__content ">
                    <div class="ui-tab" :class="{'ui-tab--active': activeTab === 'popular'}" @click="getComments('popular')">
                      <span class="ui-tab__label">
                        Популярные
                      </span>
                    </div>
                    <div class="ui-tab" :class="{'ui-tab--active': activeTab === 'new'}"  @click="getComments('new')">
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
<!--              <i class="far fa-bell fs-24"></i>-->
              <notification :data="data"></notification>
            </div>
          </div>
        </div>

        <comment-input :postId="data.id" :show="false"/>

        <div class="comments__content l-island-a l-mb-30">
          <comment v-for="c in comments" :data="c" :key="c.id"/>
        </div>
        <infinite-loading spinner="waveDots" :identifier="infiniteId" @distance="1" @infinite="infiniteHandler">
          <div slot="no-results"></div>
          <div slot="no-more"></div>
        </infinite-loading>
      </div>
    </div>
  </div>
</template>

<script>
  import VueTextareaAutosize  from 'vue-textarea-autosize'
  import Notification from "../../components/Buttons/Notification";
  import axios from "axios";
  import Comment from "./Comment";
  import CommentInput from "./CommentInput";
  import EventBus from "../../plugins/event-bus";
  import InfiniteLoading from "vue-infinite-loading";


  export default {
    name: "CommentsBlock",
    props: ['user', 'data', 'count'],
    components: {CommentInput, Comment, VueTextareaAutosize, InfiniteLoading, Notification},
    data() {
      return {
        comment: '',
        comments: [],
        activeTab: 'popular',
        page: 1,
        infiniteId: +new Date(),
      }
    },
    mounted() {
      EventBus.$on('createdComment', (data) => {
        if (data.parent){
          if (data.parent.parent_id){
            this.comments.forEach((value, index, array) => {
              if (value.id === data.parent.parent_id) this.comments[index].replies.push(data.comment)
            });
          }else{
            this.comments.forEach((value, index, array) => {
              if (value.id === data.parent.id) this.comments[index].replies.push(data.comment)
            });
          }
          EventBus.$emit('hideReplyForm', false);
        }else{
          this.comments.push(data.comment)
        }

        this.$parent.data.comments_count += 1;
      });

    },
    methods: {
      infiniteHandler($state) {
        axios.get('/api/post/'+this.$route.params.postSlug+'/comments?page='+this.page+'&type='+this.activeTab)
          .then((data) => {
            if (data.data.data.length) {
              this.page = this.page + 1;
              $.each(data.data.data, (key, value) => {
                this.comments.push(value);
              });

              $state.loaded();
            } else {
              $state.complete();
            }
          });
      },

      getComments(type) {
        this.type = type;
        this.activeTab = type;
        this.comments = [];
        this.page = 1;
        this.infiniteId += 1;
      },
    },
  }
</script>

<style>

</style>
