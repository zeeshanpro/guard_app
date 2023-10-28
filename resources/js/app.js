import './bootstrap';

import 'admin-lte/plugins/jquery/jquery.min.js';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';

import 'admin-lte/dist/js/adminlte.min.js';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import mitt from 'mitt';
import { createRouter, createWebHistory } from 'vue-router';

import Routes from './routes.js';

import Dashboard from './components/Dashboard.vue';
import Files from './pages/Files.vue';

const app = createApp({});
const emitter = mitt();
const router = createRouter({
    history: createWebHistory(),
    routes: Routes,
});

app.component('dashboard', Dashboard);
app.component('files', Files);
app.use(router);
app.config.globalProperties.$emitter = emitter;
app.mount('#app');