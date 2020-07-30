<template>
    <div>
      <avatar-setting></avatar-setting>
      <br>
      <main-info></main-info>
      <br>
      <social></social>
    </div>
</template>

<script>
  import MainInfo from "../../components/User/Settings/MainInfo";
  import AvatarSetting from "../../components/User/Settings/Avatar";
  import Social from "../../components/User/Settings/Social";
  export default {
    components: {Social, AvatarSetting, MainInfo}
  }
</script>
