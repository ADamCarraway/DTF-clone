<template>
  <div class="mobile-bar-container" v-if="user">
    <div class="mobile-bar">
      <div class="mobile-bar__feed">
        <router-link :to="{ name: 'index' }" class="mobile-bar__link">
          <ion-icon name="home-outline" class="mobile-bar__icon icon icon--v_home"></ion-icon>
        </router-link>
      </div><!---->
      <!--      <div data-v-3bc7ee00="" class="mobile-bar__messenger">-->
      <!--        <div data-v-3bc7ee00="" href="/m" class="mobile-bar__link">-->
      <!--          <svg data-v-3bc7ee00="" height="28" width="28" class="mobile-bar__icon icon icon&#45;&#45;v_messenger">-->
      <!--            <use xlink:href="#v_messenger"></use>-->
      <!--          </svg> &lt;!&ndash;&ndash;&gt;-->
      <!--        </div>-->
      <!--      </div>-->
      <div class="mobile-bar__notifications">
        <router-link
            :to="{ name: 'user.notifications', params: {'slug': user.slug} }"
            class="mobile-bar__link">
          <ion-icon name="notifications-outline" class="mobile-bar__icon icon icon--v_bell"></ion-icon>
        </router-link>
      </div>
      <div class="mobile-bar__profile">
        <div class="navigation-user navigation-user--top-position">
          <div class="navigation-user-profile">
            <el-dropdown trigger="click" placement="bottom-end" style="display: flex;">
              <span class="el-dropdown-link dropdown_down">
            <router-link :to="{ name: 'user', params: {slug: user.slug} }"
                         class="site-header-user-profile__avatar not-active">
              <div class="site-header-user-profile__avatar-image"
                   :style="{'background-image': 'url('+user.avatar+')'}"></div>
            </router-link>
              </span>
              <el-dropdown-menu slot="dropdown">
                <div class="at-dropdown-menu-item__title">Профиль</div>
                <router-link :to="{ name: 'user', params: {slug: user.slug} }"
                             class="at-dropdown-menu__item">
                  <div class="item__image">
                    <img :src="user.avatar">
                  </div>
                  <span class="item__text">{{ user.name }}</span>
                </router-link>

                <router-link :to="{ name: 'user.drafts', params:{'slug': user.slug}}" class="at-dropdown-menu__item" v-if="user.drafts_count">
                  <div class="item__icon">
                    <ion-icon name="document-outline"></ion-icon>
                  </div>
                  <span class="item__text">Черновики <div class="item__badge">{{user.drafts_count}}</div></span>
                </router-link>

                <router-link :to="{ name: 'user.favorites', params:{'slug': user.slug}}" class="at-dropdown-menu__item">
                  <div class="item__icon">
                    <ion-icon name="bookmark-outline"></ion-icon>
                  </div>
                  <span class="item__text">Закладки</span>
                </router-link>


                <router-link :to="{ name: 'user.settings.main', params: {slug: user.slug} }" class="at-dropdown-menu__item">
                  <div class="item__icon">
                    <ion-icon name="settings-outline"></ion-icon>
                  </div>
                  <span class="item__text">Настройки</span>
                </router-link>

                <a href="#" class="at-dropdown-menu__item" @click.prevent="logout" style="color: rgb(233, 42, 64);">
                  <div class="item__icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                  </div>
                  Выйти
                </a>
              </el-dropdown-menu>

            </el-dropdown>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";


export default {
  name: "MobileMenu",
  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),
  },
}
</script>

<style scoped>

</style>
