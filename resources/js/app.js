require('./bootstrap');

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

/* Oruga */
import Oruga from '@oruga-ui/oruga-next'
import '@oruga-ui/oruga-next/dist/oruga-full.css'
/* Oruga */

/* Font awesome */
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(fas);
/* Font awesome */

import store from "./store/";
import routes from "./routes";

import App from "./App.vue";


const router = createRouter({
    history: createWebHistory(),
    routes
})


const app = createApp(App)
    .use(store)
    .use(router)
    .use(Oruga, {
        iconPack: 'fas',
        iconComponent: 'vue-fontawesome'
    });

app.mixin(require('./mixins/asset.js'));
app.component("VueFontawesome", FontAwesomeIcon);
app.mount('#app');
