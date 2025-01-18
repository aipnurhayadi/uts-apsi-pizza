import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import {
    create as createNaive,
    NDialogProvider,
    NMessageProvider,
} from 'naive-ui';
import { createApp, h } from 'vue';
import OpenLayersMap from 'vue3-openlayers';

import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import 'vue3-openlayers/styles.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const options = {
    debug: true,
};

// setup naive ui
const naive = createNaive();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({
            render: () =>
                h(NDialogProvider, h(NMessageProvider, h(App, props))),
        })
            .use(plugin)
            .use(ZiggyVue)
            .use(naive)
            .use(OpenLayersMap, options)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
