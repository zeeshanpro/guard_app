import './bootstrap';

import 'admin-lte/plugins/jquery/jquery.min.js';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';

import 'admin-lte/dist/js/adminlte.min.js';

import { createApp } from 'vue/dist/vue.esm-bundler.js';

import { createRouter, createWebHistory } from 'vue-router';

import Routes from './routes.js';
import App from './components/layouts/app.vue';
import Dashboard from './components/Dashboard.vue';
import Files from './pages/Files.vue';
import Login from './pages/auth/Login.vue';
import Register from './pages/auth/Register.vue';

const app = createApp(App);

app.component('dashboard', Dashboard);
app.component('files', Files);
app.component('login', Login);
app.component('Register', Register);
app.use(Routes);
app.mount('#app');