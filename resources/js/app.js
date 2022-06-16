require('./bootstrap');

import { createApp } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router'

import store from "./store/";
import routes from "./routes";

import exampleComponent from "./components/ExampleComponent";

const router = createRouter({
    history: createWebHashHistory(),
    routes
})


const app = createApp({})
    .use(store)
    .use(router)
    .component('example', exampleComponent)
    .mount('#app');
