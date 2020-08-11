<template>
  <div class="layout__right-column layout__sticky" :class="[{'layout__right-column-hide' : !show}]">
    <div class="live l-h-full" :class="[{'live-hide' : !show}]">
      <div class="live__caption" :class="[{'live__caption_border-hide' : !show}]" @click="show=!show">

        <p class="live__title" :class="[{'live__title-hide' : !show}]">
          Комментарии
        </p>

        <div class="live__toggle">
          <i class="icon icon-arrow-right fs-24" v-if="show"></i>
          <i class="icon icon-arrow-left fs-24" v-else></i>
        </div>

      </div>
      <div class="live__content" v-if="show">
        <div class="live__scrollable_parent">
          <div class="live__scrollable">
            dsadsadsa
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "LiveLenta",
    data() {
      return {
        show: true
      }
    }
  }
</script>

<style scoped>
  .layout__right-column-hide {
    width: 80px;
  }

  .live-hide {
    width: auto;
  }

  .live__caption_border-hide::after{
    display:none;
  }

</style>
