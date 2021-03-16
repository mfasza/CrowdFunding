import Vue from 'vue'
import Vuex from 'vuex'
import transaction from './store/transaction.js';
import alert from './store/alert.js'
import auth from './store/auth.js'
import dialog from "./store/dialog.js";
import VuexPersist from 'vuex-persist'

const vuexPersist = new VuexPersist({
    key: 'crowdfunding',
    storage: localStorage
})

Vue.use(Vuex);

const store = new Vuex.Store({
    plugins: [vuexPersist.plugin],
    modules: {
        transaction,
        alert,
        auth,
        dialog
    }
});

export default store;