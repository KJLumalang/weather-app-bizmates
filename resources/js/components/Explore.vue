<template>
	<div class="h-screen pb-14 bg-right bg-cover" style="background-image: url('/images/bg.svg');">
		<!-- Navigation Bar -->
		<div class="w-full container mx-auto p-6">
			<div class="w-full flex items-center justify-between">

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
		<div class="container px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center ">
			<div class="flex flex-col w-full slide-in-bottom-h1">
				<div class="rounded-lg shadow-lg p-6 mb-6">
					<h2 class="text-3xl font-bold text-gray-800">{{ city }}</h2>
					<p class="text-2xl text-gray-600">{{ formattedDate }}</p>
					<p class="text-1xl text-gray-600">{{ currentTime }}</p>
				</div>
			</div>

			<div class="container mx-auto flex flex-wrap flex-col md:flex-row items-center">
				<!-- Weather Data -->
				<div class="flex flex-wrap w-full justify-start">
					<div class="w-1/2 lg:w-1/4 mb-6 px-1 slide-in-bottom-subtitle">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Temperature</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].temp.toFixed(1) }}° Celsius</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>

					<div class="w-1/2 lg:w-1/4 mb-6 px-1 slide-in-bottom-subtitle">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Humidity</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].humidity }}%</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>

					<div class="w-1/2 lg:w-1/4 mb-6 px-1 slide-in-bottom-subtitle">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Wind Speed</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].wind_speed }} km/h</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>

					<div class="w-1/2 lg:w-1/4 mb-6 px-1 slide-in-bottom-subtitle">
						<div class="rounded-lg shadow-lg p-6" v-if="weatherData">
							<h2 class="text-1xl md:text-2xl font-bold text-gray-800 mb-4">Weather</h2>
							<p class="text-xl md:text-4xl text-gray-600">{{ weatherData.list[0].weather }}</p>
							<a href="https://dashboard.openweather.co.uk/" class="text-indigo-500 hover:text-indigo-700 mt-4 inline-block">Learn more</a>
						</div>
					</div>
					<!-- Places Data -->
					<div class="w-full px-1 fade-in">
						<div class="rounded-lg shadow-lg p-6 mb-6" v-if="placesData.length">
							<h2 class="text-2xl font-bold text-gray-800 mb-4">Popular Places</h2>
							<ul>
								<li v-for="place in paginatedPlaces" :key="place.fsq_id" class="text-gray-600 mb-2">
									<h3 class="font-semibold">{{ place.name }}</h3>
									<p class="text-gray-500">Categories: {{ place.categories.map(category => category.name).join(', ') }}</p>
									<p class="text-gray-500">Address: {{ place.location.formatted_address }}</p>
									<p class="text-gray-500">Distance: {{ place.distance }} meters</p>
									<p class="text-gray-500">Status: {{ place.closed_bucket === 'LikelyOpen' ? 'Open' : 'Closed' }}</p>
									<span v-if="place.chains.length > 0" class="text-gray-500"> (Chains: {{ place.chains.map(chain => chain.name).join(', ') }})</span>
									<p class="text-gray-500">Coordinates: ({{ place.geocodes.main.latitude }}, {{ place.geocodes.main.longitude }})</p>
									<a :href="'https://foursquare.com/v/' + place.fsq_id" class="text-blue-500" target="_blank">More Info</a>
								</li>
							</ul>
							<!-- Pagination Controls -->
							<div class="flex justify-between mt-4">
								<button @click="prevPage" :disabled="currentPage === 1" class="bg-indigo-500 text-white px-4 py-2 rounded bounce-top-icons"><<</button>
								<button @click="nextPage" :disabled="currentPage === totalPages" class="bg-indigo-500 text-white px-4 py-2 rounded bounce-top-icons">>></button>
							</div>
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
	import Swal from 'sweetalert2'; 

	export default {
		components: {
			SearchBar
		},
		data() {
			return {
				city: 'Tokyo',
				weatherData: null,
				placesData: [],
				error: '',
				currentPage: 1,
				itemsPerPage: 2,
				isFirstLoad: true
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
			},
			totalPages() {
				return Math.ceil(this.placesData.length / this.itemsPerPage);
			},
			paginatedPlaces() {
				const start = (this.currentPage - 1) * this.itemsPerPage;
				return this.placesData.slice(start, start + this.itemsPerPage);
			}
		},
		methods: {
			async fetchData(city) {
				this.city = city;
				this.error = '';
				try {
					const weatherResponse = await axios.get(`/api/weather/${city}`);
					const placesResponse = await axios.get(`/api/places/${city}`);

					this.weatherData = weatherResponse.data;
					this.placesData = placesResponse.data.results;

					if (!this.isFirstLoad) {
						if (this.placesData.length > 0) {
							Swal.fire('Success', `${city} found!`, 'success');
						} else {
							await Swal.fire({
								title: 'Not Found',
								text: 'No places found for this city.',
								icon: 'warning',
								showCancelButton: true,
								confirmButtonText: 'Try Another City',
								cancelButtonText: 'Reset to Tokyo',
							}).then((result) => {
								if (result.isDismissed) {
									this.city = 'Tokyo';
									this.fetchData('Tokyo');
								}
							});
						}
					}

					this.isFirstLoad = false;
					
				} catch (error) {
                	console.error('Error fetching data', error);

					Swal.fire({
						title: 'Not Found',
						text: `City not found: ${city}. Please try another one.`,
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Try Another City',
						cancelButtonText: 'Reset to Tokyo',
					}).then((result) => {
						if (result.isDismissed) {
							// Reset to Tokyo if city is not found
							this.city = 'Tokyo';
							this.fetchData('Tokyo');
						}
					});
				}
			},
			nextPage() {
				if (this.currentPage < this.totalPages) {
					this.currentPage++;
				}
			},
			prevPage() {
				if (this.currentPage > 1) {
					this.currentPage--;
				}
			}
		},
		mounted() {
			this.fetchData('Tokyo'); // default city data on page load
		}
	};
</script>

<style scoped>
	slide-in-bottom{-webkit-animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) both;animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) both}
	.slide-in-bottom-h1{-webkit-animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) .5s both;animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) .5s both}
	.slide-in-bottom-subtitle{-webkit-animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) .75s both;animation:slide-in-bottom .5s cubic-bezier(.25,.46,.45,.94) .75s both}
	.fade-in{-webkit-animation:fade-in 1.2s cubic-bezier(.39,.575,.565,1.000) 1s both;animation:fade-in 1.2s cubic-bezier(.39,.575,.565,1.000) 1s both}
	.bounce-top-icons{-webkit-animation:bounce-top .9s 1s both;animation:bounce-top .9s 1s both}
	
	@-webkit-keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}
	@-webkit-keyframes bounce-top{0%{-webkit-transform:translateY(-45px);transform:translateY(-45px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in;opacity:1}24%{opacity:1}40%{-webkit-transform:translateY(-24px);transform:translateY(-24px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}65%{-webkit-transform:translateY(-12px);transform:translateY(-12px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}82%{-webkit-transform:translateY(-6px);transform:translateY(-6px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}93%{-webkit-transform:translateY(-4px);transform:translateY(-4px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}25%,55%,75%,87%{-webkit-transform:translateY(0);transform:translateY(0);-webkit-animation-timing-function:ease-out;animation-timing-function:ease-out}100%{-webkit-transform:translateY(0);transform:translateY(0);-webkit-animation-timing-function:ease-out;animation-timing-function:ease-out;opacity:1}}@keyframes bounce-top{0%{-webkit-transform:translateY(-45px);transform:translateY(-45px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in;opacity:1}24%{opacity:1}40%{-webkit-transform:translateY(-24px);transform:translateY(-24px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}65%{-webkit-transform:translateY(-12px);transform:translateY(-12px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}82%{-webkit-transform:translateY(-6px);transform:translateY(-6px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}93%{-webkit-transform:translateY(-4px);transform:translateY(-4px);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}25%,55%,75%,87%{-webkit-transform:translateY(0);transform:translateY(0);-webkit-animation-timing-function:ease-out;animation-timing-function:ease-out}100%{-webkit-transform:translateY(0);transform:translateY(0);-webkit-animation-timing-function:ease-out;animation-timing-function:ease-out;opacity:1}}
	@-webkit-keyframes fade-in{0%{opacity:0}100%{opacity:1}}@keyframes fade-in{0%{opacity:0}100%{opacity:1}}
</style>
