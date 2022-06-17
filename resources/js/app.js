require('./bootstrap');

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import store from "./store/";
import routes from "./routes";

import App from "./App.vue";


const router = createRouter({
    history: createWebHistory(),
    routes
})


const app = createApp(App)
    .use(store)
    .use(router);

app.mixin(require('./mixins/asset.js'));
app.mount('#app');
