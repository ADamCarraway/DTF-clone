import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
import vue from 'vue'
// state
export const state = {
  user: null,
  token: Cookies.get('token'),
  userSubs: {}
}

// getters
export const getters = {
  user: state => state.user,
  userSubs: state => state.userSubs,
  token: state => state.token,
  check: state => state.user !== null
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN](state, {token, remember}) {
    state.token = token
    Cookies.set('token', token, {expires: remember ? 365 : null})
  },

  [types.FETCH_USER_SUCCESS](state, {user}) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE](state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null

    Cookies.remove('token')
  },

  [types.UPDATE_USER](state, {user}) {
    Object.keys(user).forEach(key => {
      vue.set(state.user, key, user[key]);
    });
  },

  [types.DESTROY_USER_SUBSCRIPTIONS](state, {slug}) {
    vue.delete(state.userSubs, slug)
  },

  [types.FETCH_USER_SUBSCRIPTIONS](state, {subs}) {
    if (Object.keys(subs).length === 0) return state.userSubs = {};
    state.userSubs = subs
  },

  [types.ADD_USER_SUBSCRIPTION](state, {sub}) {
    vue.set(state.userSubs, sub.slug, sub);
  }
}

// actions
export const actions = {
  saveToken({commit, dispatch}, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser({commit}) {
    try {
      const {data} = await axios.get('/api/user')

      commit(types.FETCH_USER_SUBSCRIPTIONS, {subs: data.subscriptions})
      commit(types.FETCH_USER_SUCCESS, {user: data})
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  updateUser({commit}, payload) {
    commit(types.UPDATE_USER, payload)
  },

  addUserSubscription({commit}, payload) {
    commit(types.ADD_USER_SUBSCRIPTION, payload)
  },

  destroyUserSubscription({commit}, payload) {
    commit(types.DESTROY_USER_SUBSCRIPTIONS, payload)
  },

  async logout({commit}) {
    try {
      await axios.post('/api/logout')
    } catch (e) {
    }

    commit(types.LOGOUT)
  },

  async fetchOauthUrl(ctx, {provider}) {
    const {data} = await axios.post(`/api/oauth/${provider}`)

    return data.url
  }
}
