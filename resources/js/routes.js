import Dashboard from './components/Dashboard.vue';
import Files from './pages/Files.vue';
const routes = [
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
        path: "/resources/js/components/ViewFiles.vue",
        name: "View Reports",
        component: () =>
          import("@/components/ViewFiles.vue"),
        meta: { title: "View Files", requiresAuth: true },
        children: [
          {
            path: "@/components/ViewFiles/:breadcrumb*",
            component: () =>
              import("@/components/ViewFiles.vue"),
            props: true
          }
        ]
      },
];

export default routes;



