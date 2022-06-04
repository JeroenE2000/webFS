require('./bootstrap');

import { createApp } from 'vue';
import DishComponent from "./components/DishComponent";

const app = createApp({})
app.component('dish-component', DishComponent)
app.mount('#app')
