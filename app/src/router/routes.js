import store from '@state/store'

// auth related routes
const authRoutes = [
    {
        path: '/login',
        name: 'login',
        component: () => lazyLoadView(import('@views/pages/account/login')),
        meta: {
            beforeResolve(routeTo, routeFrom, next) {
                if (store.getters['auth/loggedIn']) {
                    next({ name: 'Bookings' })
                } else {
                    next()
                }
            },
        },
    },
    {
        path: '/register',
        name: 'register',
        component: () => lazyLoadView(import('@views/pages/account/register')),
        meta: {
            beforeResolve(routeTo, routeFrom, next) {
                if (store.getters['auth/loggedIn']) {
                    next({ name: 'Bookings' })
                } else {
                    // Continue to the login page
                    next()
                }
            },
        },
    },
    {
        path: '/logout',
        name: 'logout',
        meta: {
            authRequired: true,
            beforeResolve(routeTo, routeFrom, next) {
                store.dispatch('auth/logOut')
                const authRequiredOnPreviousRoute = routeFrom.matched.some(
                    (route) => route.meta.authRequired
                )
                next()
            },
        },
    },
]

// error pages
const errorPagesRoutes = [
    {
        path: '/404',
        name: '404',
        component: require('@views/pages/secondary/error-404').default,
        props: true,
    },
    {
        path: '*',
        redirect: '404',
    },
]

// bookings
const bookingsRoutes = [
    {
        path: '/',
        name: 'Bookings',
        icon: 'home',
        component: () => lazyLoadView(import('@views/pages/bookings/bookings')),
        meta: { authRequired: true },
        props: (route) => ({ user: store.state.auth.currentUser || {} }),
    },
]

const authProtectedRoutes = [
    ...bookingsRoutes,
]
const allRoutes = [...authRoutes, ...authProtectedRoutes, ...errorPagesRoutes]

export { allRoutes, authProtectedRoutes }

function lazyLoadView(AsyncView) {
    const AsyncHandler = () => ({
        component: AsyncView,
        loading: require('@components/_loading').default,
        delay: 400,
        timeout: 10000,
    })

    return Promise.resolve({
        functional: true,
        render(h, { data, children }) {
            return h(AsyncHandler, data, children)
        },
    })
}
