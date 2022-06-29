import {createRouter, createWebHistory} from "vue-router";
import store from "@/store";
import authRoutes from "@/routes/auth-routes";
import menuRoutes from "@/routes/menu-routes";


const routes = [
    ...authRoutes,
    {
        path: '/404',
        name: 'PageNotExist',
        component: () => import('@/views/Errors/404.vue'),
        meta: {
            layout: 'ErrorLayout'
        }
    },
    ...menuRoutes,
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
