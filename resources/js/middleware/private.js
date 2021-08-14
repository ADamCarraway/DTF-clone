import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].slug !== to.params.slug) {
    next({ name: 'user' })
  } else {
    next()
  }
}
