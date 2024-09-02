import { createRouter, createWebHistory } from 'vue-router';
import NotFound from "./pages/NotFound.vue";
import Trips from "./pages/Trips.vue";
import AboutUs from "./pages/AboutUs.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "Trips",
            component: Trips,
        },
        {
            path: "/about-us",
            name: "AboutUs",
            component: AboutUs,
        },
        {
            //Prende tutte le rotte esistenti, se non e' presente ti manda sulla NotFound
            path: '/:catchAll(.*)',
            component: NotFound,
            name: 'NotFound',
        }
    ],
});
export { router };