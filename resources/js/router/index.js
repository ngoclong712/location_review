import { createRouter,createWebHistory } from 'vue-router'

import DefaultLayout from '../layouts/DefaultLayout.vue'
import Home from '../views/Home.vue'

import AuthLayout from '../layouts/AuthLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'

const routes = [
    {
        path: '/',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'home',
                component: Home,
            }
        ]
    },
    {
        path: '/auth',
        component: AuthLayout,
        children: [
            {
                path: 'login',
                name: 'login',
                component: Login,
            },
            {
                path: 'register',
                name: 'register',
                component: Register,
            }
        ]
    }
]

const router= createRouter({
    history: createWebHistory(),
    routes,
})

export default router
