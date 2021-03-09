import Vue from 'vue'
import Vuex from 'vuex'
import transaction from './store/transaction.js';
import alert from './store/alert.js'

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    transaction,
    alert
  }
});

export default store;