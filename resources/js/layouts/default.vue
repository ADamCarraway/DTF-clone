<template>
  <div>
    <navbar/>
    <div class="main layout">
      <sidebar/>
      <div class="layout__content l-relative">
        <child id="page_wrapper"/>
      </div>
      <live-lenta/>
    </div>
  </div>
</template>

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

