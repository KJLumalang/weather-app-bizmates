import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import ExploreComponent from './components/Explore.vue'; // Ensure the path is correct
import SearchBar from './components/SearchBar.vue'; // Ensure the path is correct

const app = createApp({});

// Register components globally if needed
app.component('explore-component', ExploreComponent);
app.component('search-bar', SearchBar); // Register SearchBar if used in the Blade file

app.mount('#app');
