import {createRouter, createWebHistory} from "vue-router";
import authRoutes, {addUnknownUsersRedirect} from "@/routes/auth-routes";
import menuRoutes from "@/routes/menu-routes";
import {loadLayoutMiddleware} from "@/routes/middleware/loadLayout";


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


router.beforeEach(loadLayoutMiddleware);
addUnknownUsersRedirect(router)


export default router;
