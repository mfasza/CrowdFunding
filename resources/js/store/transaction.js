export default {
    namespaced:true,

    state: {
        transactions: 0
    },
    mutations: {
        insert (state) {
            state.transactions++
        }
    },
    actions: {
        donate({commit}){
            commit('insert');
        }
    },
    getters: {
        transactions: (state) => state.transactions
    }
}