<template>
  <div v-if="false"
    class="subsite_subscribe_button subsite_subscribe_button--size-default subsite_subscribe_button--notifications-disabled subsite_subscribe_button--with-notifications l-ml-12 lm-ml-0 lm-mr-12 subsite_subscribe_button--state-inactive">

    <div class="subsite_subscribe_button__main" data-button="subscribe">


      <div class="ui-button ui-button--subscribe ui-button--1 ui-button--wide" v-if="!status">
        <svg class="icon icon--ui_plus" width="12" height="12" xmlns="http://www.w3.org/2000/svg">
          <use xlink:href="#ui_plus"></use>
        </svg>
        <span>Подписаться</span>
      </div>

      <div class="ui-button ui-button--unsubscribe ui-button--5" v-if="status">
<!--        <i class="fas fa-times icon&#45;&#45;ui_close"></i>-->
        <span>Отписаться</span>
      </div>

    </div>

    <div
      class="ui-button ui-button--only-icon ui-button--5 ui-button--notifications l-ml-12 subsite_subscribe_button__notifications"
      data-button="notifications">
      <i class="far fa-bell"></i>
    </div>

  </div>
</template>

<script>
  export default {
    name: "SubscriptionButton",
    props: ['status']
  }
</script>

<style scoped>

</style>
