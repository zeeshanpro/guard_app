import { createApp } from 'vue';
import Vuex from 'vuex';

createApp(Vuex);

const store =  new Vuex.Store({
  state: {
    token: null,
  },
  mutations: {
    setToken(state, token) {
      state.token = token;

      // Store the value in localStorage
      localStorage.setItem('token', token);
    },
    // Mutation to initialize state from localStorage on page load
    initializeState(state) {
      if (localStorage.getItem('token')) {
        state.token = localStorage.getItem('token');
      }
    }
  },
  actions: {
    loginOrRegister({ commit }, token) { 
      console.log('store file ' + token) 
      commit('setToken', token);
    },
  },
});

export default store;