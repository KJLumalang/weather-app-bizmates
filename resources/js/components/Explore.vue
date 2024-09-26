<template>
	<div class="h-screen pb-14 bg-right bg-cover" style="background-image: url('/images/bg.svg');">
		<!-- Navigation Bar -->
		<div class="w-full container mx-auto p-6">
			<div class="w-full flex items-center justify-between">
				<!-- Logo -->
				<a class="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="/">
				<svg class="h-8 fill-current text-indigo-600 pr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
					<path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"/>
				</svg>
				Explore
				</a>

				<!-- SearchBar Component -->
				<search-bar @search="fetchData" />
			</div>
		</div>

		<!-- Weather and Place Details -->
		<div class="container px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">
			<div class="flex flex-col w-full">
				<div class="rounded-lg shadow-lg p-6 mb-6">
					<h2 class="text-3xl font-bold text-gray-800">{{ city }}</h2>
					<p class="text-2xl text-gray-600">{{ formattedDate }}</p>
					<p class="text-1xl text-gray-600">{{ currentTime }}</p>
				</div>
			</div>

			<div class="container mx-auto flex flex-wrap flex-col md:flex-row items-center">
				<!-- Weather Data -->
				<div class="flex flex-wrap w-full justify-start">
					<div class="w-1/2 lg:w-1/4 mb-6 px-1">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Temperature</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].temp.toFixed(1) }}° Celsius</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>

					<div class="w-1/2 lg:w-1/4 mb-6 px-1">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Humidity</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].humidity }}%</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>

					<div class="w-1/2 lg:w-1/4 mb-6 px-1">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Wind Speed</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].wind_speed }} km/h</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>

					<div class="w-1/2 lg:w-1/4 mb-6 px-1">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Weather</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].weather }}</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>
					<!-- Places Data -->
					<div class="w-full px-1">
						<div class="rounded-lg shadow-lg p-6 mb-6" v-if="placesData">
							<h2 class="text-2xl font-bold text-gray-800 mb-4">Popular Places</h2>
							<ul>
								<li v-for="place in placesData" :key="place.fsq_id" class="text-gray-600 mb-2">
									<h3 class="font-semibold">{{ place.name }}</h3>
									<!-- Display Categories -->
									<p class="text-gray-500">Categories: {{ place.categories.map(category => category.name).join(', ') }}</p>
									<!-- Display Address -->
									<p class="text-gray-500">Address: {{ place.location.formatted_address }}</p>
									<!-- Display Distance -->
									<p class="text-gray-500">Distance: {{ place.distance }} meters</p>
									<!-- Display Opening Status -->
									<p class="text-gray-500">Status: {{ place.closed_bucket === 'LikelyOpen' ? 'Open' : 'Closed' }}</p>
									<!-- Display Chains if they exist -->
									<span v-if="place.chains.length > 0" class="text-gray-500"> (Chains: {{ place.chains.map(chain => chain.name).join(', ') }})</span>
									<!-- Display Coordinates -->
									<p class="text-gray-500">Coordinates: ({{ place.geocodes.main.latitude }}, {{ place.geocodes.main.longitude }})</p>
									<!-- Link to more information -->
									<a :href="'https://foursquare.com/v/' + place.fsq_id" class="text-blue-500" target="_blank">More Info</a>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import SearchBar from './SearchBar.vue';
	import axios from 'axios';

	export default {
		components: {
			SearchBar
		},
		data() {
			return {
				city: 'Tokyo',
				weatherData: null,
				placesData: null
			};
		},
		computed: {
			formattedDate() {
				const today = new Date();
				return today.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
			},
			currentTime() {
				const now = new Date();
				return now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
			}
		},
		methods: {
			async fetchData(city) {
				this.city = city;
				try {
					const weatherResponse = await axios.get(`/api/weather/${city}`);
					const placesResponse = await axios.get(`/api/places/${city}`);
					this.weatherData = weatherResponse.data;
					this.placesData = placesResponse.data.results;
				} catch (error) {
					console.error('Error fetching data', error);
				}
			}
		}
	};
</script>

<style scoped>
/* Custom styles for Explore page */
</style>
