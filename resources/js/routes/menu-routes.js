export default [
    {
        path: '/',
        name: 'Home',
        redirect: {'name': 'Menu'}
    },
    {
        path: '/menu',
        name: 'Menu',
        component: () => import('@/views/Menu/Index.vue'),
        redirect: {'name': 'Rooms'},
        children: [
            {
                path: 'settings',
                name: 'Settings',
                component: () => import('@/views/Menu/Settings.vue'),
            },
            {
                path: 'rooms',
                name: 'Rooms',
                component: () => import('@/views/Menu/Rooms.vue'),
            },
            {
                path: '/room/:id',
                name: 'Room',
                component: () => import('@/views/Room/Index.vue'),
            }
        ],
        meta: {
            layout: 'MainLayout',
            transition: 'none',
            childTransition: 'slide'
        },
    }
]
