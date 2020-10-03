<template>
    <div v-if="data && data.slug in subscriptions"
         class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
        <div v-if="!data.is_notify" @click="notify(1)">
            <div class="v-button__icon">
                <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                   aria-hidden="true"></i>
                <i v-else class="far fa-bell"></i>
            </div>
        </div>

        <div v-if="data.is_notify" @click="notify(0)">
            <div class="v-button__icon">
                <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                   aria-hidden="true"></i>
                <i v-else class="fas fa-bell"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import axios from "axios";

    export default {
        name: "Notification",
        props: ['data', 'type'],
        data() {
            return {
                loadingNotify: false,
            }
        },
        computed: {
            ...mapGetters({
                user: 'auth/user',
                subscriptions: 'auth/subscriptions',
            }),
        },
        methods: {
            notify(type) {
                this.loadingNotify = true;
                if (type) {
                    axios.post('/api/notifications/subscribe/' + this.type + 'Notify/' + this.data.id).then((res) => {
                        this.changeForNotify();
                    }).catch(() => {
                        this.loadingNotify = false;
                    })
                }

                if (!type) {
                    axios.post('/api/notifications/unsubscribe/' + this.type + 'Notify/' + this.data.id).then((res) => {
                        this.changeForUnNotify();
                    }).catch(() => {
                        this.loadingNotify = false;
                    })
                }
            },
            changeForNotify() {
                this.data.is_notify = true;
                this.$store.dispatch('auth/changeSubscriptionField', {
                    slug: this.data.slug,
                    key: 'is_notify',
                    value: 'true'
                });


                this.$Notify.success({
                    message: 'Мы уведомим вас о новых записях'
                });
                this.loadingNotify = false;
            },
            changeForUnNotify() {
                this.data.is_notify = false;
                this.$store.dispatch('auth/changeSubscriptionField', {
                    slug: this.data.slug,
                    key: 'is_notify',
                    value: 'false'
                });


                this.$Notify.success({
                    message: 'Вы отписались от уведомлений о новых записях'
                });
                this.loadingNotify = false;
            }
        },
    }
</script>

<style scoped>

</style>
