import { createRouter, createWebHistory } from 'vue-router'
import authRoutes, { addUnknownUsersRedirect } from '@/routes/auth-routes.js'
import menuRoutes from '@/routes/menu-routes.js'
import { loadLayoutMiddleware } from '@/routes/middleware/loadLayout.js'

const routes = [
    ...authRoutes,
    ...menuRoutes,
    {
        path: '/404',
        name: 'PageNotExist',
        component: () => import('@/views/Errors/404.vue'),
        meta: {
            layout: 'ErrorLayout'
        }
    },
    {
        path: '/:catchAll(.*)', // Unrecognized path automatically matches 404
        redirect: { name: 'PageNotExist' }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(loadLayoutMiddleware)
addUnknownUsersRedirect(router)

export default router
