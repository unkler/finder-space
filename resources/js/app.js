import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

//vue.js
import { createApp } from 'vue/dist/vue.esm-bundler'; 
import ArticleLike from './components/ArticleLike.vue'

const app = createApp({
    components: {
        ArticleLike,
    }
});
app.mount('#app');



