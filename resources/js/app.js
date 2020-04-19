import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import VeeValidate from 'vee-validate'
import store from './store'
import router from './routes'
import App from './App.vue'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import vuetifyOptions from './VuetifyOptions'

Vue.use(VueRouter)
Vue.use(VeeValidate)
Vue.use(Vuetify);

window.axios = require('axios')

window.axios.interceptors.response.use(null, function(error) {
    switch(error.response.status) {
        case 401:
            router.replace('/login');
            break
        case 403:
            //
            break
        case 404:
            //
            break
        case 429:
            //
            break
        default:
            break
    }
    return Promise.reject(error)
})

new Vue({
    router,
    store,
    vuetify: new Vuetify(vuetifyOptions),
    render: h => h(App)
}).$mount('#app')
