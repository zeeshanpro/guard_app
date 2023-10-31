import { createWebHistory, createRouter } from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import Files from './pages/Files.vue';
import FileList from './components/FileList.vue';
import Login from './pages/auth/Login.vue';
import Register from './pages/auth/Register.vue';
const routes = [
    {
        path: '/login',
        name: 'admin.login',
        component: Login,
    },
    {
        path: '/register',
        name: 'admin.register',
        component: Register,
    },
    {
        path: '/admin/dashboard',

        name: 'admin.dashboard',

        component: Dashboard,
    },

    {
        path: '/admin/files',

        name: 'admin.files',

        component: Files,
    },

    {
        path: '/admin/folders/:id',

        name: 'FileList',

        component: FileList,
    }
    // {
    //     path: "/resources/js/components/ViewFiles.vue",
    //     name: "View Reports",
    //     component: () =>
    //       import("@/components/ViewFiles.vue"),
    //     meta: { title: "View Files", requiresAuth: true },
    //     children: [
    //       {
    //         path: "@/components/ViewFiles/:breadcrumb*",
    //         component: () =>
    //           import("@/components/ViewFiles.vue"),
    //         props: true
    //       }
    //     ]
    //   },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;



