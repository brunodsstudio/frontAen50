import '../css/app.css';
import '../css/style.css';
import'../lib/slick/slick.css';
import'../lib/slick/slick-theme.css';

import './bootstrap';

import $ from 'jquery';


import { createInertiaApp } from '@inertiajs/vue3';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { createVuetify } from 'vuetify';
    import 'vuetify/styles'; // Import Vuetify styles
    import * as components from 'vuetify/components';
    import * as directives from 'vuetify/directives';

import 'bootstrap/dist/css/bootstrap.css';

window.jQuery = $; // Makes jQuery available globally                                                                                                              

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const vuetify = createVuetify({
        components,
        directives,
    });


createInertiaApp({
    render: renderToString,
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
           .use(vuetify)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}); // .
