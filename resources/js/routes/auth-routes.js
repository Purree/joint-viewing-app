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
    }
]
