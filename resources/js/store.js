import Vue from 'vue'
import Vuex from 'vuex'
import transaction from './store/transaction';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    transaction
  }
});

export default store;