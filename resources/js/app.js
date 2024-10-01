import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import ExploreComponent from './components/Explore.vue'; 
import SearchBar from './components/SearchBar.vue'; 

const app = createApp({});

app.component('explore-component', ExploreComponent);
app.component('search-bar', SearchBar); 

app.mount('#app');
