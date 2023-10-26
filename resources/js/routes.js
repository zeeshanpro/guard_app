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
    }
];

export default routes;



