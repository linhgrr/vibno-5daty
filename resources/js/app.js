import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import CommentComponent from './components/CommentComponent.vue';

window.axios = axios

const app = createApp({
    components: {
        CommentComponent
    }
});

app.mount('#app');


