<template>
  <div class="head-notifies__items">
    <div name="js-notify" class="notification" style="cursor: default;">
          <span class="notification__image">
            <ion-icon name="alert-outline" :class="'icon--anon-notification'"></ion-icon>
          </span>
      <div class="notification__text l-mr-10">
            <span name="js-notification-text">
              Авторизуйтесь или зарегистрируйтесь, чтобы оценивать материалы, создавать записи и писать комментарии.
            </span>
      </div>
      <div class="notification__footer">
        <social-auth-box :isNotification="true"/>
<!--        <div class="l-flex l-mt-9 l-mb-10">-->

<!--          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;ifb l-mr-10"-->
<!--               @click="login('facebook')">-->
<!--            <ion-icon name="logo-facebook"></ion-icon>-->
<!--          </div>-->
<!--          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;ivk l-mr-10"-->
<!--               @click="login('vk')">-->
<!--            <ion-icon name="logo-vk"></ion-icon>-->
<!--          </div>-->
<!--          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;igg l-mr-10"-->
<!--               @click="login('google')">-->
<!--            <ion-icon name="logo-google"></ion-icon>-->
<!--          </div>-->
<!--          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;igg l-mr-10"-->
<!--               @click="login('twitch')">-->
<!--            <ion-icon name="logo-twitch"></ion-icon>-->
<!--          </div>-->
<!--          &lt;!&ndash;          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;itw l-mr-10">&ndash;&gt;-->
<!--          &lt;!&ndash;            <svg class="icon icon&#45;&#45;ui_twitter" width="15" height="12"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_twitter"></use></svg>&ndash;&gt;-->
<!--          &lt;!&ndash;          </div>&ndash;&gt;-->
<!--          <div class="ui-button ui-button&#45;&#45;5 ui-button&#45;&#45;only-icon ui-button&#45;&#45;small ui-button&#45;&#45;iemail l-mr-10">-->
<!--            <ion-icon name="mail-outline"></ion-icon>-->
<!--          </div>-->
<!--        </div>-->
      </div>
    </div>
  </div>
</template>

<script>
import SocialAuthBox from "../SocialAuthBox";
export default {
  name: "NotificationForGuest",
  components: {SocialAuthBox},
}
</script>

<style scoped>

</style>
