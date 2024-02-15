import 'vue-toastification/dist/index.css'
import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '@/../../vendor/tightenco/ziggy/dist/vue.m'
import { modal } from 'momentum-modal'
import Toast from 'vue-toastification'
import toastNotifications from '@/Plugins/toastNotifications.js'
import errorHandler from '@/Plugins/errorHandler'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        app.use(plugin)
            .use(Toast, {
                transition: 'Vue-Toastification__slideBlurred',
                maxToasts: 20,
                newestOnTop: true,
                closeButton: false,
                hideProgressBar: true,
            })
            .use(toastNotifications)
            .use(errorHandler(app))
            .use(ZiggyVue)
            .use(modal, {
                resolve: (name) =>
                    resolvePageComponent(
                        `./Modals/${name}.vue`,
                        import.meta.glob('./Modals/**/*.vue'),
                    ),
            })
            .mount(el)

        return app
    },
    progress: {
        color: '#4B5563',
    },
})
