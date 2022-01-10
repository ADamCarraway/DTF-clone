<template>
  <div class="rating-page page--index">
    <div class="subsite_head l-island-a l-island-bg l-pt-20 l-pb-5">
      <div class="subsite_head__row">
        <div class="subsite_head__name l-fs-30 lm-fs-22 l-lh-30 l-fw-600">
          Рейтинг сообществ и блогов
        </div>
      </div>

      <div class="subsite_head__row">
        <div class="subsite_head__description l-fs-15 l-lh-21 lm-fs-13 lm-lh-18">
          Десять лучших авторов и&nbsp;комментаторов, а&nbsp;также администраторы первых десяти сообществ из&nbsp;рейтинга
          по&nbsp;итогам месяца бесплатно получают <a href="/plus">Plus-аккаунт</a> на&nbsp;месяц.
        </div>
      </div>
    </div>

    <div class="ui-tabs ui-tabs--default ui-tabs--no-scroll l-mb-15 l-island-bg">
      <div class="ui-tabs__scroll">
        <div class="ui-tabs__content l-island-a">
          <a @click="changeFilter('now')" class="ui-tab" :class="{'ui-tab--active': current === 'now'}">
            <span class="ui-tab__label" style=" text-transform:capitalize;">{{ month }}</span>
          </a>
          <a @click="changeFilter('3month')" class="ui-tab" :class="{'ui-tab--active': current === '3month'}">
            <span class="ui-tab__label">3 месяца</span>
          </a>
          <a @click="changeFilter('all')" class="ui-tab" :class="{'ui-tab--active': current === 'all'}">
            <span class="ui-tab__label">За все время</span>
          </a>
        </div>
      </div>
    </div>

    <categories-rating-table/>

    <users-rating-table/>

    <commentators-rating-table/>

  </div>
</template>

<script>
  import axios from "axios";
  import RatingTableItem from "../components/Table/RatingTableItem";
  import UsersRatingTable from "../components/Table/UsersRatingTable";
  import CategoriesRatingTable from "../components/Table/CategoriesRatingTable";
  import EventBus from "../plugins/event-bus";
  import CommentatorsRatingTable from "../components/Table/CommentatorsRatingTable";
  import moment from 'moment'
  import {mapGetters} from "vuex";

  export default {
    components: {CommentatorsRatingTable, CategoriesRatingTable, UsersRatingTable, RatingTableItem},
    data() {
      return {
        'current': 'now'
      }
    },
    computed: {
      month() {
        return moment().locale("ru").format('MMMM')
      }
    },
    methods: {
      changeFilter(type) {
        this.current = type;

        EventBus.$emit('changeFilterForRatingTable', type);
      }
    },
    metaInfo() {
      return {title: 'Рейтинг сообществ и блогов'}
    }
  }
</script>
