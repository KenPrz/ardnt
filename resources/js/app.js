import './bootstrap';
import '../css/app.css';
import 'primeicons/primeicons.css'
import "vue-toastification/dist/index.css";


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toast from "vue-toastification";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const options = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    timeout: 2500,
    newestOnTop: true,
    position: "bottom-right",
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.3,
    hideProgressBar: false,
    closeButton: "button",
    icon: false,
    rtl: false,
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, options)
            .mount(el);
    },
    progress: {
        color: '#a02334',
    },
});
