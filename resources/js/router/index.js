import { createRouter, createWebHistory } from 'vue-router'

import AuthLayout from '../layouts/AuthLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'

import DefaultLayout from '../layouts/DefaultLayout.vue'
import Home from '../views/Home.vue'

import AdminLayout from "@/layouts/AdminLayout.vue";
import AdminBanners from "@/views/admin/Banners.vue";
import AdminManagers from "@/views/admin/Managers.vue";
import AdminUsers from "@/views/admin/Users.vue";
import AdminReviews from "@/views/admin/Reviews.vue";
import AdminReports from "@/views/admin/Reports.vue";

import ManagerLayout from "@/layouts/ManagerLayout.vue";
import ManagerBanners from "@/views/manager/Banners.vue";
import ManagerUsers from "@/views/manager/Users.vue";
import ManagerReviews from "@/views/manager/Reviews.vue";
import ManagerReports from "@/views/manager/Reports.vue";

import Test from "@/views/Test.vue";

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
      path: '/test',
      component: Test,
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
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { roles: [3] },
        children: [
            { path: '', redirect: { name: 'admin.banners' } },
            { path: 'banners', name: 'admin.banners', component: AdminBanners },
            { path: 'managers', name: 'admin.managers', component: AdminManagers },
            { path: 'users', name: 'admin.users', component: AdminUsers },
            { path: 'reviews', name: 'admin.reviews', component: AdminReviews },
            { path: 'reports', name: 'admin.reports', component: AdminReports },
        ]
    },
    {
        path: '/manager',
        component: ManagerLayout,
        meta: { roles: [2] },
        children: [
            { path: '', redirect: { name: 'manager.banners' } },
            { path: 'banners', name: 'manager.banners', component: ManagerBanners },
            { path: 'users', name: 'manager.users', component: ManagerUsers },
            { path: 'reviews', name: 'manager.reviews', component: ManagerReviews },
            { path: 'reports', name: 'manager.reports', component: ManagerReports },
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
