import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
import vue from 'vue'
import moment from "moment";

// state
export const state = {
  user: null,
  token: Cookies.get('token'),
  subscriptions: {},
};

// getters
export const getters = {
  user: state => state.user,
  subscriptions: state => state.subscriptions,
  token: state => state.token,
  check: state => state.user !== null
};

// mutations
export const mutations = {
  [types.SAVE_TOKEN](state, {token, remember}) {
    state.token = token;
    Cookies.set('token', token, {expires: remember ? 365 : null})
  },

  [types.FETCH_USER_SUCCESS](state, {user}) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE](state) {
    state.token = null;
    Cookies.remove('token')
  },

  [types.LOGOUT](state) {
    state.user = null;
    state.token = null;

    Cookies.remove('token')
  },

  [types.UPDATE_USER](state, {user}) {
    Object.keys(user).forEach(key => {
      vue.set(state.user, key, user[key]);
    });
  },

  [types.DESTROY_SUBSCRIPTIONS](state, {slug}) {
    vue.delete(state.subscriptions, slug)
  },

  [types.FETCH_SUBSCRIPTIONS](state, {subs}) {
    if (Object.keys(subs).length === 0) return state.subscriptions = {};
    Object.keys(subs).forEach(key => {
      vue.set(state.subscriptions, key, subs[key]);
    });
  },

  [types.ADD_SUBSCRIPTION](state, {sub}) {
    vue.set(state.subscriptions, sub.slug, sub);
    vue.set(state.subscriptions[sub.slug], 'date', moment().format());
  },

  [types.CHANGE_SUBSCRIPTION_FIELD](state, {slug, key, value}) {
    vue.set(state.subscriptions[slug], key, value);
  },
};

// actions
export const actions = {
  saveToken({commit, dispatch}, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser({commit}) {
    try {
      const {data} = await axios.get('/api/user');

      commit(types.FETCH_SUBSCRIPTIONS, {subs: data.subscriptions});
      commit(types.FETCH_USER_SUCCESS, {user: data})
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  updateUser({commit}, payload) {
    commit(types.UPDATE_USER, payload)
  },

  addSubscription({commit}, payload) {
    commit(types.ADD_SUBSCRIPTION, payload)
  },

  destroySubscription({commit}, payload) {
    commit(types.DESTROY_SUBSCRIPTIONS, payload)
  },

  changeSubscriptionField({commit}, payload) {
    commit(types.CHANGE_SUBSCRIPTION_FIELD, payload)
  },

  async logout({commit}) {
    try {
      await axios.post('/api/logout')
    } catch (e) {
    }

    commit(types.LOGOUT)
  },

  async fetchOauthUrl(ctx, {provider}) {
    const {data} = await axios.post(`/api/oauth/${provider}`);

    return data.url
  }
};
