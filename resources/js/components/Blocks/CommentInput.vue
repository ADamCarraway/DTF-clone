<template>
  <div class="comments__footer l-island-a l-clear">
    <div class="comments_form">
      <div class="comments_form__editor">
        <div class="thesis thesis--empty">
          <textarea-autosize
            class="content_editable"
            placeholder="Написать комментарий..."
            v-model="comment"
            :min-height="30"
            :max-height="350"/>
          <div class="thesis__panel">
            <div class="thesis__attaches"></div>
            <div class="thesis__custom_buttons"></div>
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
    props: ['postId'],
    data() {
      return {
        comment: ''
      }
    },
    methods: {
      send() {
        axios.post('/api/comment/store', {'comment': this.comment, 'id': this.postId}).then((res) => {
          EventBus.$emit('createdComment', {comment: res.data});
          this.comment = '';
        }).catch(() => {
        })
      },
    }
  }
</script>

<style scoped>

</style>
