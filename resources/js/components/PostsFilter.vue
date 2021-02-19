<template>
    <div class="ui-sorting">
        <div class="ui-filters l-island-round ui-filters--responsive">
            <div class="ui-filters__inner">
                <div class="ui-rounded-button ui-rounded-button--responsive ui-rounded-button--has-active-child"
                     :class="{'ui-rounded-button--active': $route.name === routes.index}">
                    <router-link :to="{ name: routes.index }" class="ui-rounded-button__link"
                                 @click.native="open('popular')">
                        Популярное
                    </router-link>
                </div>
                <div class="ui-rounded-button ui-rounded-button--responsive"
                     :class="{'ui-rounded-button--active': $route.name === routes.new}">
                    <router-link :to="{ name: routes.new }" class="ui-rounded-button__link" @click.native="open('new')">
                        Свежее
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../plugins/event-bus";

    export default {
        name: "PostsFilter",
        props: ['routes'],
        methods: {
            open(filter) {
                EventBus.$emit('changePostsRoute', {filter: filter});
                EventBus.$emit('changeCommentsRoute', { filter: filter})
            }
        }
    }
</script>

<style scoped>

</style>
