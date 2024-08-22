import "./assets/css/satoshi.css"
import "./assets/css/style.css"
import "flatpickr/dist/flatpickr.min.css"

import { createApp } from "vue"
import { createPinia } from "pinia"
import PiniaPersistedState from "pinia-plugin-persistedstate"
import VueApexCharts from "vue3-apexcharts"

import App from "./App.vue"
import router from "./router"

const app = createApp(App)
const pinia = createPinia()
pinia.use(PiniaPersistedState)

app.use(pinia)
app.use(router)
app.use(VueApexCharts)

app.mount("#app")
