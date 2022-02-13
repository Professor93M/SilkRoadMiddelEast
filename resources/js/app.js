// require('./bootstrap');
import { quillEditor, Quill } from 'vue3-quill'
// import customQuillModule from 'customQuillModule'
// Quill.register('modules/customQuillModule', customQuillModule)
import VueSweetalert2 from 'vue-sweetalert2'
import "../../public/css/sweetalert2.min.css"
import VueNumberInput from '@chenfengyuan/vue-number-input';
import 'vueperslides/dist/vueperslides.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import store from "./store"
import { Link } from '@inertiajs/inertia-vue3'
library.add(fas) // FontAwesome
// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin, Link as InertiaLink} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
// import { Link as InertiaLink } from '@inertiajs/inertia-vue3'

const el = document.getElementById('app');
// const metaManager = createMetaManager()

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .component('inertia-link', InertiaLink)
    .component('fa', FontAwesomeIcon)
    .mixin({ methods: { route } })
    .use(store)
    .use(quillEditor)
    .use(VueSweetalert2)
    .use(InertiaPlugin)
    .use(Link)
    .mount(el)

InertiaProgress.init({ color: '#db2745' });
