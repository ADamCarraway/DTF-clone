<template>
  <div class="content-footer__item">
    <div class="repost_button">
      <el-dropdown trigger="click" @command="share" placement="bottom-start">
      <span class="el-dropdown-link">
        <ion-icon src="/icons/share-outline.svg"></ion-icon>
      </span>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item class="v-shares-popover__item" command="link">
            <div class="v-shares-popover__icon">
              <i class="fas fa-link"></i>
            </div>
            <div class="v-shares-popover__title"><span>Копировать ссылку</span></div>
          </el-dropdown-item>
          <el-dropdown-item class="v-shares-popover__item" command="vk">
            <div class="v-shares-popover__icon">
              <i class="fab fa-vk"></i>
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
