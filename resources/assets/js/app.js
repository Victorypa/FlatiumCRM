import Vue from 'vue'
import store from './store'
import router from './routes'
import VueCarousel from 'vue-carousel'
import BasicHeader from './components/Partials/BasicHeader'
import Navigation from './components/Partials/Navigation'
import App from './components/App'

Vue.use(VueCarousel);

require('./bootstrap');

window.Vue = require('vue')

Vue.component('basic-header', BasicHeader)
Vue.component('navigation', Navigation)

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.auth.isLoggedIn) {
        next({ name: 'login' })
        return
    }
    if (to.path === '/login' && store.state.auth.isLoggedIn) {
        next({ name: 'services' })
        return
    }
    next()
})


const app = new Vue({
    components: { App },
    router,
    store
}).$mount('#app')
