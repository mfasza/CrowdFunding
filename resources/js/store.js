import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
      donationCount: 0
    },
    mutations: {
      increment (state) {
        state.donationCount++
      }
    },
    actions: {
        donate(context){
            context.commit('increment');
        }
    }
});

export default store;