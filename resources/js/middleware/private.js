import store from '~/store'

export default (to, from, next) => {
    if(!store.getters['auth/user']){
        next({name: '403'})
    } else if (store.getters['auth/user'] && store.getters['auth/user'].slug === to.params.slug) {
        next()
    } else {
        next({name: '403'})
    }
}
// http://127.0.0.1:8000/u/101-sergey-serousov/notifications