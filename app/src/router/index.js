import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMeta from 'vue-meta'
import NProgress from 'nprogress/nprogress'
import store from '@state/store'
import { allRoutes } from './routes'

Vue.use(VueRouter)
Vue.use(VueMeta, {
    keyName: 'page',
})

const router = new VueRouter({
    routes: allRoutes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    },
})

router.beforeEach((routeTo, routeFrom, next) => {
    if (routeFrom.name !== null) {
        // Start the route progress bar.
        NProgress.start()
    }

    // Check if auth is required on this route
    // (including nested routes).
    const authRequired = routeTo.matched.some((route) => route.meta.authRequired)

    // If auth isn't required for the route, just continue.
    if (!authRequired) return next()

    // If auth is required and the user is logged in...
    if (store.getters['auth/loggedIn']) {
        // Validate the local user token...
        return store.dispatch('auth/validate').then((validUser) => {
            // Then continue if the token still represents a valid user,
            // otherwise redirect to login.
            validUser ? next() : redirectToLogin()
        })
    }

    // If auth is required and the user is NOT currently logged in,
    // redirect to login.
    redirectToLogin()

    function redirectToLogin() {
        next({ name: 'login', query: { redirectFrom: routeTo.fullPath } })
    }
})

router.beforeResolve(async (routeTo, routeFrom, next) => {
    try {
        for (const route of routeTo.matched) {
            await new Promise((resolve, reject) => {
                if (route.meta && route.meta.beforeResolve) {
                    route.meta.beforeResolve(routeTo, routeFrom, (...args) => {
                        if (args.length) {
                            if (routeFrom.name === args[0].name) {
                                NProgress.done()
                            }
                            next(...args)
                            reject(new Error('Redirected'))
                        } else {
                            resolve()
                        }
                    })
                } else {
                    resolve()
                }
            })
        }
    } catch (error) {
        return
    }

    next()
})

router.afterEach((routeTo, routeFrom) => {
    NProgress.done()
})

export default router
