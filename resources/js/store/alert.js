export default {
    namespaced:true,

    state: {
        snackbar: false,
        text: '',
        timeout: 1600,
        color: '',
        outline: false
    },
    mutations: {
        snackbar (state) {
            state.snackbar = true
        },
        notSnackbar (state, value) {
            state.snackbar = value
        },
        text(state, value) {
            state.text = value
        },
        color(state, value) {
            state.color = value
        },
        outline(state, value) {
            state.outline = value
        }
    },
    actions: {
        showAlert({commit}, payload){
            commit('snackbar');
            commit('text', payload.text);
            commit('color', payload.color);
            commit('outline', payload.outline);
        },
        hideAlert({commit}, value){
            commit('notSnackbar', value);
        }
    },
    getters: {
        snackbar: (state) => state.snackbar,
        text: (state) => state.text,
        timeout: (state) => state.timeout,
        color: (state) => state.color,
        outline: (state) => state.outline
    }
}