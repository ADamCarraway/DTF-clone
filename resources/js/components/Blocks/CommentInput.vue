<template>
  <div class="comments__footer l-island-a l-clear">
    <div class="comments_pseudo_form l-clear" v-if="!type && !formShow" @click="focusInput()">

      <span class="comments_pseudo_form__text">Написать комментарий...</span>

      <div class="comments_pseudo_form__button">
        <ion-icon src="/icons/link-outline.svg" :class="'icon--attach-link'"></ion-icon>
      </div>
      <div class="comments_pseudo_form__button">
        <ion-icon src="/icons/image-outline.svg" :class="'icon--ui_image'"></ion-icon>
      </div>

    </div>
    <div class="comments_form" v-if="show || formShow">
      <div class="comments_form__editor">
        <div class="thesis thesis--empty">
          <textarea-autosize
            ref="myTextarea"
            class="content_editable"
            placeholder="Написать комментарий..."
            v-model="comment"
            :min-height="30"
            :max-height="350"/>
          <div class="thesis__panel">
            <div class="thesis__attaches"></div>
            <div class="thesis__custom_buttons">
              <div class="thesis__custom_button ui-button ui-button--4 ui-button--small" v-if="parent" @click="hideReplyForm()">Отменить</div>
            </div>
            <div class="thesis__submit ui-button ui-button--1" @click="send()">Отправить</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import EventBus from "../../plugins/event-bus";
  import axios from "axios";

  export default {
    name: "CommentInput",
    props: ['postId', 'parent', 'show', 'type'],
    data() {
      return {
        comment: '',
        url: 'comment/store',
        formShow: false
      }
    },
    methods: {
      send() {
        if (this.parent){
          this.url = 'reply/store'
        }
        axios.post('/api/'+this.url, {'comment': this.comment, 'id': this.postId, 'commentId': this.parent ? this.parent.id : null}).then((res) => {
          EventBus.$emit('createdComment', {comment: res.data, parent: this.parent});
          this.comment = '';
        }).catch(() => {
        })
      },
      hideReplyForm(){
        EventBus.$emit('hideReplyForm');
      },
      focusInput(){
        this.formShow = true
        setTimeout(() => {
          this.$refs.myTextarea.$el.select()
        }, 1);

      }
    }
  }
</script>

<style scoped>

</style>
