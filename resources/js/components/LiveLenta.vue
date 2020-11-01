<template>
  <div class="layout__right-column layout__sticky" :class="[{'layout__right-column-hide' : !show}]">
    <div class="live l-h-full" :class="[{'live-hide' : !show}]">
      <div class="live__caption" :class="[{'live__caption_border-hide' : !show}]" @click="show=!show">

        <p class="live__title" :class="[{'live__title-hide' : !show}]">
          Комментарии
        </p>

        <div class="live__toggle">
          <i class="fas fa-chevron-right" v-if="show"></i>
          <i class="fas fa-chevron-left" v-else></i>
        </div>

      </div>
      <div class="live__content" v-if="show">
        <div class="live__scrollable_parent">
          <div class="live__scrollable">
            <div v-for="i in [1,2,3,4,5,6,7,8,9]" :key="i" class="live__item live__item--comment">
              <div class="live__item__header">
                <a href="https://dtf.ru/u/104087-konstantin-gavrilov" class="live__item__user">
                  <img class="andropov_image live__item__user__image" air-module="module.andropov"
                       src="https://leonardo.osnova.io/d0899f05-8489-abde-8cfc-60986c29cb96/-/scale_crop/224x224/center/">
                  <p class="live__item__user__name">
                    <span>Sergey Serousov</span>
                  </p>
                </a>
                <a
                  href="https://dtf.ru/games/224785-razrabotchiki-amnesia-rebirth-podelilis-novymi-podrobnostyami-horrora?comment=7045486"
                  class="live__item__date">
                  <time class="time" air-module="module.date" data-date="1601840057" data-type="short"></time>
                </a>
              </div>
              <div>
                <a
                  href="https://dtf.ru/games/224785-razrabotchiki-amnesia-rebirth-podelilis-novymi-podrobnostyami-horrora?comment=7045486"
                  class="live__item__content">
                  <div class="live__item__text">Просто в момент очередного дропа задуматься и поступить на этот раз
                    иначе. Сквозь страх…
                  </div>
                </a>
              </div>
              <a
                href="https://dtf.ru/games/224785-razrabotchiki-amnesia-rebirth-podelilis-novymi-podrobnostyami-horrora"
                class="live__item__title "
                title="Разработчики Amnesia: Rebirth поделились новыми подробностями хоррора">
                <span>Разработчики Amnesia: Rebirth…</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import EventBus from "../plugins/event-bus";

  export default {
    name: "LiveLenta",
    data() {
      return {
        show: true,
        hideLive: false
      }
    },
    mounted() {
      EventBus.$on('hideLive', () => {
        this.show = !this.show;
      });
    },
  }
</script>

<style scoped>
  .layout__right-column-hide {
    width: 80px;
  }

  .live-hide {
    width: auto;
  }

  .live__caption_border-hide::after {
    display: none;
  }

</style>
