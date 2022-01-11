<template>
  <div>
    <navbar/>
    <div class="main layout">
      <sidebar/>
      <div class="layout__content l-relative">
        <child id="page_wrapper"/>
      </div>
      <live-lenta v-if="$route.name && ($route.name).indexOf('admin')+1 !== 1"
          :class="{'page--index' : $route.name &&
          ($route.name).indexOf('user.favorites')+1 !== 1 &&
          ($route.name).indexOf('user.notifications')+1 !== 1 &&
          ($route.name).indexOf('user.post')+1 !== 1 &&
          ($route.name).indexOf('category.post')+1 !== 1 &&
           (($route.name).indexOf('user')+1 === 1 || ($route.name).indexOf('category')+1 === 1) ||
          ($route.name && (($route.name).indexOf('404')+1 === 1 || ($route.name).indexOf('403')+1 === 1))
      }"
      />
    </div>
    <mobile-menu/>
  </div>
</template>
<!--          v-if="$route.name && ($route.name).indexOf('user')+1 !== 1"-->


<script>
import Navbar from '~/components/Navbar'
import LiveLenta from "../components/LiveLenta";
import Sidebar from "../components/Sidebar";
import MobileMenu from "../components/Blocks/MobileMenu";

export default {
  name: 'MainLayout',

  components: {
    MobileMenu,
    Sidebar,
    LiveLenta,
    Navbar
  }
}
</script>

