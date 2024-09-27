<template>
    <div class="relative text-gray-600 w-1/2 sm:w-1/4 lg:w-1/4">
        <input
            v-model="searchQuery"
            @keyup.enter="handleSearch"
            @focus="showDropdown = true"
            @input="filterCities"
            @keydown.down.prevent="moveDown"
            @keydown.up.prevent="moveUp"
            @keydown.enter.prevent="selectHighlightedCity"
            class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none w-full"
            type="search"
            placeholder="Search city"
        />

        <button @click="handleSearch" class="absolute right-0 top-0 mt-3 mr-4">
            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.966 56.966" width="512px" height="512px">
                <path
                    d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23
                    s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92
                    c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17
                    s-7.626,17-17,17s-17-7.626-17-17S14.61,6,23.984,6z"
                />
            </svg>
        </button>
        
        <ul v-if="showDropdown && filteredCities.length" class="absolute w-full bg-white border border-gray-300 rounded-lg mt-1 z-10">
            <li
                v-for="(city, index) in filteredCities"
                :key="city"
                @click="selectCity(index)"
                :class="{'bg-indigo-200': index === highlightedIndex}"
                class="cursor-pointer p-2 hover:bg-indigo-100"
            >
                {{ city }}
            </li>
        </ul>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            searchQuery: '',
            cities: ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'],
            filteredCities: [],
            showDropdown: false,
            highlightedIndex: -1
        };
    },
    methods: {
        handleSearch() {
            const query = this.searchQuery || 'Tokyo'; // default to Tokyo
            this.$emit('search', query);
            this.showDropdown = false; // Hide dropdown after search
            this.highlightedIndex = -1; // Reset highlighted index
        },
        filterCities() {
            this.filteredCities = this.cities.filter(city =>
                city.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
            this.showDropdown = this.filteredCities.length > 0;
            this.highlightedIndex = -1; // Reset highlighted index when filtering
        },
        selectCity(index) {
            this.searchQuery = this.filteredCities[index];
            this.handleSearch();
        },
        moveDown() {
            if (this.highlightedIndex < this.filteredCities.length - 1) {
                this.highlightedIndex += 1;
            }
        },
        moveUp() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex -= 1;
            }
        },
        selectHighlightedCity() {
            if (this.highlightedIndex >= 0) {
                this.searchQuery = this.filteredCities[this.highlightedIndex];
                this.handleSearch();
            }
        }
    }
};
</script>
  
<style scoped>
    input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: none;
        appearance: none;
    }
    ul {
        max-height: 300px;
        overflow-y: auto;
    }
    li {
        padding: 10px;
    }
</style>
