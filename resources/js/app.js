import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './App.vue'
import vuetify from './plugins/vuetify.js'
import './bootstrap.js'

router.beforeEach((to, from, next) => {
    if (to.name === 'chat') {
        if (store.getters['auth/guest']) {
            next(false)
            store.dispatch('alert/showAlert', {
                text: 'Login Required',
                color: 'error',
                outline: true
            })
            store.dispatch('dialog/setComponent', 'login')
        } else {
            next()
        }
    } else {
        next()
    }
});

const app = new Vue({
    el: '#app',
    store,
    router,
    vuetify ,
    components: {
        App
    }
});
