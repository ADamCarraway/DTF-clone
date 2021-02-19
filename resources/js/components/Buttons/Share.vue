<template>
  <div class="content-footer__item">
    <div class="repost_button">
      <el-dropdown trigger="click" @command="share" placement="bottom-start">
      <span class="el-dropdown-link">
        <i class="far fa-share-square l-fs-20"></i>
      </span>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item class="v-shares-popover__item">
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
    methods: {
      share(method){
        switch (method) {
          case "vk":
            console.log()
            window.open('https://vk.com/share.php?url='+this.data.vk_url,'_blank', "width=300,height=600")
            break;
          default:
        }
      },
    }
  }
</script>

<style scoped>

</style>
