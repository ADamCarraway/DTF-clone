<template>
  <div>
    <div class="subsite_head l-island-a l-island-bg l-pv-15">
      <div class="subsite_head__row subsite_head__row--inline l-mr-auto">
        <div class="subsite_head__face l-s-54 lm-s-42 l-mr-15">
          <img class="andropov_image subsite_head__face__avatar andropov_image--bordered andropov_image--zoomable"
               style="background-color: transparent;"
               src="https://leonardo.osnova.io/f7118460-be16-486b-7ae1-e6d70b8340f4/-/scale_crop/108x108/center/">
          <div class="image_uploader" air-module="module.imageUploader">
            <svg class="icon icon--ui_photo" width="22" height="21">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ui_photo"></use>
            </svg>
          </div>
        </div>
      </div>

      <div class="subsite_head__row subsite_head__row--inline subsite_head__row--actions">
        <a href="https://dtf.ru/u/10255-sergey-serousov/settings"
           class="subsite_head__settings ui-button ui-button--only-icon ui-button--5 l-ml-15 lm-ml-0 lm-mr-15">
          <at-button icon="icon-settings"></at-button>
        </a>
        <div class="subsite_head__qr l-ml-12 lm-ml-0 lm-mr-12 lm-hidden"
             title="Авторизоваться через QR-код">
          <i class="icon icon-slack icon--ui_qr"></i>
        </div>
      </div>

      <div class="subsite_head__row">
        <p class="subsite_head__name l-to-ellipsis l-fs-30 lm-fs-22 l-lh-34 l-fw-600" style="color: #000">Сергей Сероусов</p>
        <div class="subsite_head__karma subsite_head__karma--positive l-fs-13 l-ml-10 l-mt-3">+1</div>
      </div>
      <div class="subsite_head__row">
        <div class="subsite_head__registration_date l-fs-13">
          Зарегистрировался <time class="time">23&nbsp;дек&nbsp;2016</time>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    middleware: 'auth',

    metaInfo() {
      return {title: this.$t('home')}
    }
  }
</script>
