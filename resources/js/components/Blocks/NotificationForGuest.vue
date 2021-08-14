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
        <div class="l-flex l-mt-9 l-mb-10">

          <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--ifb l-mr-10" data-social="fb" data-refresh="1" air-click="auth_social_buttons"><svg class="icon icon--ui_facebook" width="8" height="17"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_facebook"></use></svg></div>
          <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--ivk l-mr-10" data-social="vk" data-refresh="1" air-click="auth_social_buttons"><svg class="icon icon--ui_vkontakte" width="17" height="10"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_vkontakte"></use></svg></div>
          <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--igg l-mr-10" data-social="gg" data-refresh="1" air-click="auth_social_buttons"><svg class="icon icon--ui_google" width="14" height="14"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_google"></use></svg></div>
          <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--itw l-mr-10" data-social="tw" data-refresh="1" air-click="auth_social_buttons"><svg class="icon icon--ui_twitter" width="15" height="12"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_twitter"></use></svg></div>
          <div class="ui-button ui-button--5 ui-button--only-icon ui-button--small ui-button--iemail l-mr-10" data-social="email" data-refresh="1" air-click="show_auth"><svg class="icon icon--ui_email" width="14" height="10"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_email"></use></svg></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "NotificationForGuest"
    }
</script>

<style scoped>

</style>
