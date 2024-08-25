import { createApp } from 'vue';

//Rotte
import { router } from "./router";

//Stile General
import './style/style.scss';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';

import App from './App.vue';

createApp(App).use(router).mount('#app');
// 
