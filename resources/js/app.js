import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

//vue.js
import { createApp } from 'vue/dist/vue.esm-bundler'; 
import ArticleLike from './components/ArticleLike.vue'
import ArticleTagsInput from './components/ArticleTagsInput.vue'

const app = createApp({
    components: {
        ArticleLike,
        ArticleTagsInput,
    }
});
app.mount('#app');



