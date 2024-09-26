<template>
    <div>
        <h2>Places in {{ city }}</h2>
        <ul>
            <li v-for="place in places" :key="place.id">{{ place.name }}</li>
        </ul>
        <button @click="fetchPlaces">Get Places</button>
    </div>
</template>
  
  <script>
  export default {
    data() {
      return {
        city: 'Tokyo',
        places: []
      }
    },
    methods: {
      fetchPlaces() {
        axios.get(`/api/places/${this.city}`)
            .then(response => {
                
                if (response.data && response.data.results) {
                    this.places = response.data.results; 
                } else {
                    this.places = []; 
                }
            })
            .catch(error => {
                console.error("Error fetching places:", error);
                this.places = []; 
            });
      }
    }
  }
  </script>
  