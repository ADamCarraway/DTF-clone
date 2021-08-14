import store from '~/store'
import EventBus from "../plugins/event-bus";

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
    EventBus.$emit('loginModal', true);
    next({ name: 'index' })
  } else {
    next()
  }
}
