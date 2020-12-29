<template>
  <div data-id="8466578" data-date="1609269227" data-reply_to="0" data-rating="0" data-user_id="91342" data-donate="0"
       class="comments__item">
    <div class="comments__item__space">
      <div class="comments__item__self comments__item__self--author comments__item__self--major">
        <div class="comments__item__header">
          <div class="comments__item__users">

            <!-- User -->
            <a class="comments__item__user t-link" href="https://dtf.ru/u/91342-adam-carraway">
              <img class="andropov_image comments__item__user__image andropov_image--bordered"
                   style="background-color: transparent;"
                   :src="data.user.avatar">
              <p class="comments__item__user__name">
                <span class="user_name">{{ data.user.name }}</span>
              </p>
            </a>
          </div>

          <!-- Rows separator -->
          <div class="comments__item__sep"></div>

          <!-- Date -->
          <div class="comments__item__date t-link">
            <time class="time">{{ data.date }}</time>
          </div>
        </div>

        <!-- Vote -->
<!--        <div class="vote vote&#45;&#45;comment" air-module="module.votes" data-id="8466578" data-type="4"-->
<!--             data-type-str="comment" data-symbols="—|–" data-state="0" data-with-users="1" data-content-id="285557"-->
<!--             data-subsite-id="91342" data-subsite-name="Adam Carraway"-->
<!--             data-subsite-avatar="https://leonardo.osnova.io/d0899f05-8489-abde-8cfc-60986c29cb96/"-->
<!--             data-subsite-url="https://dtf.ru/u/91342-adam-carraway" data-place="content" data-count="0">-->

<!--          <div class="vote__button vote__button&#45;&#45;minus">-->
<!--            <svg class="icon icon&#45;&#45;ui_arrow_down" width="14" height="12" xmlns="http://www.w3.org/2000/svg">-->
<!--              <use xlink:href="#ui_arrow_down"></use>-->
<!--            </svg>-->
<!--            <div class="vote__button__action"></div>-->
<!--          </div>-->

<!--          <div class="vote__value t-ff-1-500 l-fs-16">-->
<!--            <span class="vote__value__v vote__value__v&#45;&#45;real">0</span>-->
<!--          </div>-->

<!--          <div class="vote__button vote__button&#45;&#45;plus">-->
<!--            <svg class="icon icon&#45;&#45;ui_arrow_up" width="14" height="12" xmlns="http://www.w3.org/2000/svg">-->
<!--              <use xlink:href="#ui_arrow_up"></use>-->
<!--            </svg>-->
<!--            <div class="vote__button__action"></div>-->
<!--          </div>-->

<!--        </div>-->


        <!-- Content -->
        <div class="comments__item__content">

          <div class="comments__item__text"><p>{{ data.comment }}</p></div>

          <!-- Display donate value -->

        </div>
        <!-- Reply -->
        <div class="comments__item__reply" air-click="place_form?to=item&amp;id=8466578&amp;mode=reply">Ответить</div>

        <!-- Favorite -->
        <div class="favorite_marker favorite_marker--type-comment favorite_marker--zero"data-count="0" title="В закладки">
          <i data-v-976b26e2="" class="far fa-bookmark"></i>
        </div>

        <!-- Admin -->
<!--        <div class="etc_control" air-module="module.etc_controls" >-->
<!--          <svg class="icon icon&#45;&#45;ui_etc" width="14" height="7" xmlns="http://www.w3.org/2000/svg">-->
<!--            <use xlink:href="#ui_etc"></use>-->
<!--          </svg>-->
<!--        </div>-->
      </div>
    </div>
    <div class="comments__item__other">
      <!-- Children comments -->
      <div class="comments__item__children"></div>
      <!-- Collapse subtree stripe -->
      <div class="comments__item__collapse_subtree" air-click="collapse_subtree?id=8466578&amp;state=1"></div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Comment",
    props: ['data']
  }
</script>

<style scoped>

</style>
