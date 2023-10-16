import './bootstrap.js'

import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'

createInertiaApp({
    id: 'app',
    progress: {
        showSpinner: true
    },
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .component('Head', Head)
            .component('Link', Link)
            .use(plugin)
            .mount(el)
    }
})