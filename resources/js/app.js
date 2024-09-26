/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import WeatherComponent from './components/WeatherComponent.vue';
import PlaceComponent from './components/PlaceComponent.vue';

app.component('weather-component', WeatherComponent);
app.component('place-component', PlaceComponent);

app.mount('#app');
