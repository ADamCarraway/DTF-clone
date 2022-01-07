import store from '~/store'

export default (to, from, next) => {
    if(!store.getters['auth/user']){
        next({name: 'index'})
    } else if (store.getters['auth/user'] && store.getters['auth/user'].slug === to.params.slug) {
        next()
    } else {
        next({name: '403'})
    }
}
