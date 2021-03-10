export default {
    namespaced: true,
    state: {
        status: false,
        component: 'search'
    },
    mutations: {
        setStatus: (state, payload) => {
            state.status = payload
        },
        setComponent: (state, payload) => {
            state.component = payload
        }
    },
    actions: {
        setStatus: ({commit}, status) => {
            commit('setStatus', status);
        },
        setComponent: ({commit}, component) => {
            commit('setComponent', component)
            commit('setStatus', true)
        }
    },
    getters: {
        status: state => state.status,
        component: state => state.component,
    }
}