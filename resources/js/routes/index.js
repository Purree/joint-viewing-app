import {createRouter, createWebHistory} from "vue-router";
import store from "@/store";

const routes = [
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
        path: '/404',
        name: 'PageNotExist',
        component: () => import('@/views/Errors/404.vue'),
        meta: {
            layout: 'ErrorLayout'
        }
    },
    {
        path: '/',
        name: 'Home',
        redirect: {'name': 'Menu'}
    },
    {
        path: '/menu',
        name: 'Menu',
        component: () => import('@/views/Menu/Index'),
        redirect: {'name': 'Rooms'},
        children: [
            {
                path: 'settings',
                name: 'Settings',
                component: () => import('@/views/User/Settings.vue'),
            },
            {
                path: 'rooms',
                name: 'Rooms',
                component: () => import('@/views/Menu/Rooms.vue'),
            },
        ],
        meta: {
            layout: 'MainLayout'
        },
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        redirect: {'name': 'PageNotExist'}
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
                query: {redirect: to.fullPath},
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
