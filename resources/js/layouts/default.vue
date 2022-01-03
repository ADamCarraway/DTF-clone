<template>
  <div>
    <navbar/>
    <div class="main layout">
      <sidebar/>
      <div class="layout__content l-relative">
        <child id="page_wrapper"/>
      </div>
      <live-lenta />
    </div>
  </div>
</template>
<!--v-if="$route.name && ($route.name).indexOf('user')+1 !== 1"-->
<!--:class="{'page&#45;&#45;index' : $route.name && (($route.name).indexOf('user')+1 === 1 || ($route.name).indexOf('category')+1 === 1) }"-->
<script>
  import Navbar from '~/components/Navbar'
  import LiveLenta from "../components/LiveLenta";
  import Sidebar from "../components/Sidebar";

  export default {
    name: 'MainLayout',

    components: {
      Sidebar,
      LiveLenta,
      Navbar
    }
  }
</script>

