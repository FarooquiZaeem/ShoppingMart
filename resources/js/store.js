import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    accessToken: '',
    userInfo: {},
  },
  getters: {
    accessToken: state => {
      return state.accessToken
    },
    userInfo: state => {
      return state.userInfo
    },
  },
  mutations: {
    storeAccessToken(state, accessToken) {
  		state.accessToken = accessToken;
    },
    storeUserInfo(state, userInfo) {
  		state.userInfo = userInfo;
  	},
    removeAccessToken(state) {
      state.accessToken = null;
    },
    removeUserInfo(state) {
      state.userInfo = null;
    },
  },
  actions: {
    userLogin({commit, dispatch}, loginObject) {
      localStorage.setItem('accessToken', loginObject.accessToken);
      localStorage.setItem('userInfo', JSON.stringify(loginObject.userInfo));
      dispatch('setUserState', loginObject);
    },
    setUserState({commit}, loginObject) {
      commit('storeAccessToken', loginObject.accessToken);
      commit('storeUserInfo', loginObject.userInfo);
    },
  	userLogout ({commit}) {
      localStorage.clear();
      commit('removeAccessToken');
      commit('removeUserInfo');
    }
  }
})
