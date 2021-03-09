export default {
    namespaced:true,

    state: {
        snackbar: false,
        text: 'Donasi Anda berhasil dilakukan.',
        timeout: 3500,
    },
    mutations: {
        snackbar (state) {
            state.snackbar = true
        },
        notSnackbar (state, value) {
            state.snackbar = value
        },
    },
    actions: {
        showAlert({commit}){
            commit('snackbar');
        },
        hideAlert({commit}, value){
            commit('notSnackbar', value);
        }
    },
    getters: {
        snackbar: (state) => state.snackbar,
        text: (state) => state.text,
        timeout: (state) => state.timeout
    }
}