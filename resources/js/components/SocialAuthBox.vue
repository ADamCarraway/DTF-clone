<template>
  <div>
    <!-- Google Login Button -->
    <login-with-google/>

    <!-- Twitch Login Button -->
    <login-with-twitch/>

    <!-- Facebook Login Button -->
    <login-with-facebook/>

    <div class="row">
      <div class="col-md-6">
        <!-- Twitter Login Button -->
        <login-with-twitter/>
      </div>
      <div class="col-md-6">
        <!-- GitHub Login Button -->
        <login-with-github/>
      </div>
    </div>
  </div>
</template>

<script>
  import LoginWithGithub from '~/components/LoginWithGithub'
  import LoginWithTwitter from "~/components/LoginWithTwitter";
  import LoginWithTwitch from "~/components/LoginWithTwitch";
  import LoginWithFacebook from "~/components/LoginWithFacebook";
  import LoginWithGoogle from "~/components/LoginWithGoogle";

  export default {
    name: "SocialAuthBox",
    components: {
      LoginWithGoogle,
      LoginWithFacebook,
      LoginWithTwitch,
      LoginWithTwitter,
      LoginWithGithub
    },
  }
</script>

<style scoped>

</style>
