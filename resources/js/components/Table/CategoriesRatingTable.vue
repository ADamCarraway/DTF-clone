<template>
  <div class="l-island-bg l-mb-15">
    <div class="table">
      <div class="table__row table__row--header l-island-a">
        <div class="table__cell"><strong>Сообщества</strong></div>
        <div class="table__cell"><small>Рейтинг</small></div>
        <div class="table__cell"></div>
      </div>
      <div class="table__content">
        <rating-table-item v-for="(item, index) in data" :data="item" :index="index" :key="'user-'+index"/>
      </div>
      <div class="table__row table__row--footer l-island-a" v-if="!last">
        <div class="table__more" @click="getData(false)">
          <strong>
            <small><span>Показать ещё</span>
            </small>
          </strong>
          <i class="el-icon-arrow-down"></i>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import RatingTableItem from "./RatingTableItem";
  import axios from "axios";
  import EventBus from "../../plugins/event-bus";

  export default {
    name: "CategoriesRatingTable",
    components: {RatingTableItem},
    data() {
      return {
        'page': 1,
        'data': [],
        'filter': 'now',
        'last': false
      }
    },
    methods: {
      getData(newData = false) {
        if (newData){
          this.page = 1;
          this.last = false;
        }

        axios.get('/api/rating/categories/' + this.filter + '?page=' + this.page)
          .then((response) => {
            if (newData){
              this.data = response.data.data
            }else{
              $.each(response.data.data, (key, value) => {
                this.data.push(value);
              });
            }
            this.page = this.page + 1;
            if (response.data.last_page === response.data.current_page) this.last = true;
          });
      }
    },
    mounted() {
      EventBus.$on('changeFilterForRatingTable', (filter) => {
        this.filter = filter;
        this.getData(true);
      });
      this.getData();
    },
  }
</script>

<style scoped>

</style>
