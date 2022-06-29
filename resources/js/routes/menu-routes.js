export default [
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
            layout: 'MainLayout',
            transition: 'none',
            childTransition: 'slide-down'
        },
    }
]
