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
                path: '/room/entrance/:id',
                name: 'RoomEntrance',
                component: () => import('@/views/Room/Entrance.vue'),
            },
            {
                path: '/room/:link',
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
