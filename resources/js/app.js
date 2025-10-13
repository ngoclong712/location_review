import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import './bootstrap';

import '../css/app.css'

const app = createApp(App)
app.use(Toast)
app.use(router).mount('#app')
