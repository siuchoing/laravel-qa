import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
})

// called before the route that renders this component is confirmed.
// does NOT have access to `this` component instance,
// because it has not been created yet when this guard is called!
router.beforeEach((to, from, next) => {

    // if a particular route record contains meta requires auth, we can add an and operator followed by not window auth
    if (to.matched.some(r => r.meta.requiresAuth) && !window.Auth.signedIn) {

        // redirect to the actual laravel login page by using vanilla javascript
        window.location = window.Auth.url
        return
    }
    // move on to the next hook.
    next()
    
})

export default router
