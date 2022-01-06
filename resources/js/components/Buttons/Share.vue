<template>
  <div class="content-footer__item">
    <div class="repost_button">
      <el-dropdown trigger="click" @command="share" placement="bottom-start">
      <span class="el-dropdown-link">
        <ion-icon name="share-outline"></ion-icon>
      </span>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item class="at-dropdown-menu__item etc_control__item" command="link">
            <div class="v-shares-popover__icon">
              <ion-icon name="link-outline"></ion-icon>
            </div>
            <div class="v-shares-popover__title"><span>Копировать ссылку</span></div>
          </el-dropdown-item>
          <el-dropdown-item class="at-dropdown-menu__item etc_control__item" command="bookmark">
            <div class="v-shares-popover__icon">
              <ion-icon name="bookmark-outline" v-if="!data.is_bookmarked"></ion-icon>
              <ion-icon name="bookmark" v-else></ion-icon>
            </div>
            <div class="v-shares-popover__title">
              <span v-if="!data.is_bookmarked">Добавить в закладки</span>
              <span v-else>Убрать из закладок</span>
            </div>
          </el-dropdown-item>
          <el-dropdown-item class="at-dropdown-menu__item etc_control__item" command="vk">
            <div class="v-shares-popover__icon">
              <ion-icon name="logo-vk"></ion-icon>
            </div>
            <div class="v-shares-popover__title"><span>ВКонтакте</span></div>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>

    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Share",
  props: ['data'],
  data() {
    return {
      'url': this.data.url
    }
  },
  methods: {
    share(method) {
      switch (method) {
        case "vk":
          window.open('https://vk.com/share.php?url=' + this.data.vk_url, '_blank', "width=300,height=600")
          break;
        case "bookmark":
          let value = !this.data.is_bookmarked;

          if (!value) {
            axios.delete('/api/bookmark', {data: {'bookmarked': this.data.type, 'id': this.data.id}}).then((res) => {
              this.data.is_bookmarked = false
            }).catch(() => {
            })
          }

          if (value) {
            axios.post('/api/bookmark', {'bookmarked': this.data.type, 'id': this.data.id}).then((res) => {
              this.data.is_bookmarked = true
            }).catch(() => {
            })
          }
          break;
        case "link":
          this.$copyText(this.url).then((e) => {
            this.$notify({
              message: 'Ссылка скопирована',
              type: 'success'
            });
          });
          break;
        default:
      }
    },
  }
}
</script>

<style scoped>

</style>
