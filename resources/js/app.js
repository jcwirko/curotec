import "./bootstrap";
import router from "./router/router.js";
import { createApp } from "vue";
import App from "./App.vue";
import '../css/app.css'

createApp(App).use(router).mount("#app");
