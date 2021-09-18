require('./bootstrap');
// Import modules...
import { createApp, h,resolveComponent, } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Translates from '@/Mixins/Translates';
import Helpers from '@/Mixins/Helpers';
import { VueClipboard } from '@soerenmartius/vue3-clipboard';
import { Vue3Mq } from 'vue3-mq';
// import VCalendar from 'v-calendar';
import { SetupCalendar} from 'v-calendar';

const el = document.getElementById('app');

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
            resolveErrors: page => (page.props.errors || {}),
        }),
})
    .mixin({ methods: { route } })
    .mixin(Translates)
    .mixin(Helpers)
    // Setup the plugin with optional defaults
    .use(VueClipboard)
    .use(Vue3Mq)
    .use(SetupCalendar, {
        locales: {
            "ka": {
                id: 'ka',
                dayNames: ['Bazar', 'Bazar ertəsi', 'Çərşənbə axşamı', 'Çərşənbə', 'Cümə axşamı', 'Cümə', 'Şənbə'],
                dayNamesShort: ['Ba', 'Ba.e', 'Çər.a', 'Çər', 'Cüm.a', 'Cüm', 'Şən'],
                dayNamesShorter: ['Ba', 'B.e', 'Ç.a', 'Çə', 'C.a', 'Cü', 'Şə'],
                dayNamesNarrow: ['B', 'B', 'Ç', 'Ç', 'C', 'C', 'Ş'],
                masks: {
                    L: 'YYYY-MM-DD'
                    // ...optional `title`, `weekdays`, `navMonths`, etc
                }
            }
        }
    })
    .use(InertiaPlugin)
    .mount(el);
InertiaProgress.init({ color: '#E49540' });
