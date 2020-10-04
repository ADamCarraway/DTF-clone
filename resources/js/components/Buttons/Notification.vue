<template>
    <div v-if="data && data.slug in subscriptions"
         class="v-subscribe-button__notifications v-button v-button--default v-button--size-default">
        <div v-if="!data.is_notify" @click="notify(true)">
            <div class="v-button__icon">
                <i v-if="loadingNotify" class="spinner-border spinner-border-sm" role="status"
                   aria-hidden="true"></i>
                <i v-else class="far fa-bell"></i>
            </div>
        </div>

        <div v-if="data.is_notify" @click="notify(false)">
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
        props: ['data'],
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
                    axios.post('/api/notifications/subscribe/' + this.data.type + 'Notify/' + this.data.id).then((res) => {
                        this.changeForNotify(type);
                    }).catch(() => {
                        this.loadingNotify = false;
                    })
                }

                if (!type) {
                    axios.post('/api/notifications/unsubscribe/' + this.data.type + 'Notify/' + this.data.id).then((res) => {
                        this.changeForNotify(type);
                    }).catch(() => {
                        this.loadingNotify = false;
                    })
                }
                this.loadingNotify = false;
            },
            changeForNotify(status) {
                this.data.is_notify = status;
                this.$store.dispatch('auth/changeSubscriptionField', {
                    slug: this.data.slug,
                    key: 'is_notify',
                    value: status
                });

                if (status) {
                    this.$Notify.success({
                        message: 'Мы уведомим вас о новых записях'
                    });
                } else {
                    this.$Notify.success({
                        message: 'Вы отписались от уведомлений о новых записях'
                    });
                }
            },
        },
    }
</script>

<style scoped>

</style>
