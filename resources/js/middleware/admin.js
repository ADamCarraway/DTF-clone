import store from '~/store'

export default (to, from, next) => {
  if (!store.getters['auth/user'].is_admin) {
    next({ name: 'index' })
  } else {
    next()
  }
}
