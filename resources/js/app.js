import { createApp } from 'vue'
import { createPinia } from "pinia";
import App from './App.vue'
import router from './router/index.js'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import './bootstrap';

import '../css/app.css';

import "./router/guard";

const app = createApp(App)
const pinia = createPinia()
app.use(Toast)
app.use(pinia)
app.use(router).mount('#app')
