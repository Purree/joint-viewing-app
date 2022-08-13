import AppLayout from "./layouts/AppLayout.vue";

import './bootstrap';

import "@@/app.scss"

import { createApp } from 'vue/dist/vue.esm-bundler';

/* Oruga */
import Oruga from '@oruga-ui/oruga-next'

import { bulmaConfig } from '@oruga-ui/theme-bulma'

/* Oruga */


/* Font awesome */
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(fas);
/* Font awesome */

import store from "@/store/index.js";
import router from "@/routes/index.js";

import App from "@/App.vue";


const app = createApp(App)
    .use(store)
    .use(router)
    .use(Oruga, {
        ...bulmaConfig,
        iconPack: 'fas',
        iconComponent: 'vue-fontawesome'
    });

app.component("VueFontawesome", FontAwesomeIcon);
app.component('AppLayout', AppLayout);
app.mount('#app');

window.$oruga = app.config.globalProperties.$oruga;

