import { createApp } from 'vue';
import App from './App.vue';

//Rotte
import { router } from "./router";

//Stile General
import './style/style.scss';

//Import Bootstrap
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';

// Import swiper
import 'swiper/swiper-bundle.css';

createApp(App).use(router).mount('#app');
// 
