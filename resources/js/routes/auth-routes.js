import store from "@/store";

export default [
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/views/User/Login.vue'),
        meta: {
            layout: 'AuthenticationLayout'
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('@/views/User/Register.vue'),
        meta: {
            layout: 'AuthenticationLayout'
        }
    },
    {
        path: '/forgot-password',
        name: 'ForgotPassword',
        component: () => import('@/views/User/PasswordRecovery.vue'),
        meta: {
            layout: 'AuthenticationLayout'
        }
    },
    {
        path: '/two-factor',
        name: 'TwoFactor',
        component: () => import('@/views/User/TwoFactor.vue'),
        meta: {
            layout: 'AuthenticationLayout'
        }
    }
]

export function addUnknownUsersRedirect (router) {
    const authRouteNames = ['Login', 'Register', 'ForgotPassword', 'TwoFactor']

    router.beforeEach((to, from, next) => {
        if (!authRouteNames.includes(to.name)) {
            if (!store.getters['auth/isLoggedIn']) {
                return next({
                    name: 'Login',
                    query: {redirect: to.fullPath},
                    replace: true
                })
            }
        } else if (store.getters['auth/isLoggedIn']) {
            return next({
                name: 'Home'
            })
        }

        return next()
    })
}
