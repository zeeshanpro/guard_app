import './bootstrap';

import 'admin-lte/plugins/jquery/jquery.min.js';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';

import 'admin-lte/dist/js/adminlte.min.js';

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import { createRouter, createWebHistory } from 'vue-router';

import Routes from './routes.js';

import Dashboard from './components/Dashboard.vue';

const app = createApp({});

const router = createRouter({
    history: createWebHistory(),
    routes: Routes,
});

app.component('dashboard', Dashboard);
app.use(router);

app.mount('#app');