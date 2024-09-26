<template>
    <div>
        <h2>Weather in {{ city }}</h2>
        <p v-if="weather">Temperature: {{ weather.list[0].main.temp }}°C</p>
        <button @click="fetchWeather">Get Weather</button>
    </div>
</template>
  
<script>
    export default {
        data() {
            return {
                city: 'Tokyo',
                weather: null
            }
        },
        methods: {
            fetchWeather() {
                axios.get(`/api/weather/${this.city}`)
                .then(response => {
                    this.weather = response.data;
                });
            }
        }
    }
</script>
  