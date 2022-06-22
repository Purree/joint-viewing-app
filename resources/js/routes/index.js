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
        component: () => import('../views/authentication/Login.vue'),
    },
    {
        path: "/:catchAll(.*)", // Unrecognized path automatically matches 404
        redirect: '/404',
    },
];

export default routes;
