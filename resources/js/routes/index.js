import {createRouter, createWebHistory} from "vue-router";
import store from "../store";

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/authentication/Login.vue'),
        meta: {
            layout: 'AuthenticationLayout'
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('../views/authentication/Register.vue'),
        meta: {
            layout: 'AuthenticationLayout'
        }
    },
    {
        path: '/404',
        name: 'PageNotExist',
        component: () => import('../views/errors/404.vue'),
        meta: {
            layout: 'ErrorLayout'
        }
    },
    {
        path: '/',
        name: 'Home',
        redirect: '/404'
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        redirect: '/404',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

const authRouteNames = ['Login', 'Register']

router.beforeEach((to, from, next) => {
    if (!authRouteNames.includes(to.name)) {
        if (!store.getters.isLoggedIn) {
            return next({
                name: 'Login',
                query: { redirect: to.fullPath },
                replace: true
            })
        }
    } else if (store.getters.isLoggedIn) {
        return next({
            name: 'Home'
        })
    }

    return next()
})


export default router;
