<template>
  <div>
    <form @submit.prevent="update" class="ui_form ui_form--nickname ui_form--2 l-mb-25">
      <fieldset>
        <label>Никнейм</label>
        <div class="ui-limited-input ui-limited-input--showed" ref="inputElement" data-length="17">
          <input v-model="name" class="form-control" type="text" maxlength="30"
                 name="name">
        </div>
        <div class="nickname-controls l-inline-block">
          <button class="nickname-controls__button nickname-controls__button--edit t-link-classic">
            Изменить
          </button>
        </div>
      </fieldset>
      <p class="caption ld-pl-168">Смену никнейма можно производить не чаще раза в месяц</p>
    </form>

    <form @submit.prevent="update" class="ui_form ui_form--nickname ui_form--2 l-mb-25">
      <fieldset>
        <label for="form_input_email">Эл. почта:</label>
        <input v-model="email" class="form-control" maxlength="30"
               name="email" type="email" id="form_input_email">
        <div class="nickname-controls l-inline-block">
          <button class="nickname-controls__button nickname-controls__button--edit t-link-classic">
            Изменить
          </button>
        </div>
      </fieldset>
    </form>
  </div>
</template>

<script>
  import axios from 'axios'
  import {mapGetters} from 'vuex'

  export default {
    name: "MainInfo",

    scrollToTop: false,

    data() {
      return {
        name: '',
        email: '',
      }
    },

    watch : {
      name : function (val) {
        this.$refs.inputElement.setAttribute('data-length', 30 - val.length);
        this.name = val;
      }
    },

    computed: mapGetters({
      user: 'auth/user'
    }),

    created() {
      this.name = this.user['name']
      this.email = this.user['email']
    },

    methods: {
      update() {
        let data = {
          'name': this.name,
          'email': this.email,
        }

        axios.post('/api/settings/profile', data).then((response) => {
          this.$notify({
            message: 'Данные изменены',
            type: 'success'
          });
        })

        this.$store.dispatch('auth/updateUser', {user: data})
      },
    }
  }
</script>

<style scoped>

</style>
