<template>
    <div class="auth-form__tab auth_tab auth_tab--signin-start">

        <div class="auth-form__content">
            <div class="auth-form__title l-mb-20">Вход на SITTE</div>

            <!-- Google Login Button -->
            <login-with-google/>

            <!-- Facebook Login Button -->
            <login-with-facebook/>

            <!-- Login Form Button -->
            <div class="social-auth__button" @click="showLoginForm()">
                <svg class="icon icon--ui_google" width="19" height="17">
                    <fa :icon="['fab', 'google']"/>
                </svg>
                <div class="social-auth__label">Через почту</div>
            </div>

            <div class="row at-row">
                <div class="col-md-12">
                    <!-- Twitter Login Button -->
                    <login-with-twitter/>
                </div>
                <div class="col-md-12">
                    <!--        &lt;!&ndash; GitHub Login Button &ndash;&gt;-->
                    <!--        <login-with-github/>-->

                    <!-- Twitch Login Button -->
                    <login-with-twitch/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoginWithGithub from '../components/SocialAuthButtons/LoginWithGithub'
    import LoginWithTwitter from "../components/SocialAuthButtons/LoginWithTwitter";
    import LoginWithTwitch from "../components/SocialAuthButtons/LoginWithTwitch";
    import LoginWithFacebook from "../components/SocialAuthButtons/LoginWithFacebook";
    import LoginWithGoogle from "../components/SocialAuthButtons/LoginWithGoogle";
    import EventBus from '../plugins/event-bus';

    export default {
        name: "SocialAuthBox",

        components: {
            LoginWithGoogle,
            LoginWithFacebook,
            LoginWithTwitch,
            LoginWithTwitter,
            LoginWithGithub
        },

        methods: {
            showLoginForm() {
                EventBus.$emit('show', 'login-form');
            }
        }
    }
</script>

<style scoped>

</style>
