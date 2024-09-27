# Bizmate - Weather App

## Overview
This project is a simple web application designed to provide travel information for foreign tourists visiting Japan for the first time. The app offers weather forecasts and places of interest for key cities, including Tokyo, Yokohama, Kyoto, Osaka, Sapporo, and Nagoya.

## Technologies Used
- **Frontend:** VueJS, HTML5, CSS3, JavaScript (ES6), Tailwind, SweetAlert2
- **Backend:** Laravel (PHP)
- **APIs:** 
  - OpenWeatherMap API for weather data
  - Foursquare API for venue information

## Features
- **Weather Forecast:** Displays the weather forecast using the OpenWeatherMap API.
- **Place Information:** Displays place information from the Foursquare API.
- **Responsive Design:** The application is designed to be user-friendly and responsive on both desktop and mobile devices.

## Requirements
1. Create an account on OpenWeatherMap to access the weather forecast API.
   - [OpenWeatherMap API Documentation](https://openweathermap.org/forecast5)
   - Example API request: `https://api.openweathermap.org/data/2.5/forecast?q={city name},{country code}`
  
2. Create an account on Foursquare to access the venue search API.
   - [Foursquare API Documentation](https://developer.foursquare.com/docs/api/venues/search)
   - Example API request: `https://api.foursquare.com/v2/venues/search?near=Osaka,JP&limit=5&categoryId=4deefb944765f83613cdba6e`
   - Alternatives:
     - [Foursquare Places API](https://developer.foursquare.com/docs/places-api-getting-started)
     - [Geoapify Maps API](https://www.geoapify.com/get-started-with-maps-api)

3. Please consider the database settings when running this project.
    - You can check it on the .env file.

## UI/UX
The UI is designed with the traveler in mind, focusing on simplicity and ease of use. Key design features include:
- **Clear Navigation:** Users can easily search for weather and places based on the city of interest.
- **Responsive Layout:** The app is optimized for both desktop and mobile views, ensuring accessibility on any device.

## Coding Standards
The code adheres to the following coding standards:
- **PHP Coding Standards:** PSR-1, PSR-2, PSR-4, PSR-12
  - References:
    - [PSR-1](https://www.php-fig.org/psr/psr-1/)
    - [PSR-2](https://www.php-fig.org/psr/psr-2/)
    - [PSR-4](https://www.php-fig.org/psr/psr-4/)
    - [PSR-12](https://www.php-fig.org/psr/psr-12/)
- **JavaScript Style Guide:** Compliant with the Google JavaScript Style Guide
  - [Google JavaScript Style Guide](https://google.github.io/styleguide/jsguide.html)
- **HTML & CSS:** Compliant with the Google HTML/CSS Style Guide
  - [Google HTML/CSS Style Guide](https://google.github.io/styleguide/htmlcssguide.html)
- **Object-Oriented Principles:** Followed S.O.L.I.D principles and clean code practices
  - [S.O.L.I.D. Principles](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design)
  - [Clean Code](https://www.investigatii.md/uploads/resurse/Clean_Code.pdf)

## Submission
- GitHub Repository: https://github.com/KJLumalang/weather-app-bizmates.git

## Others
- I also have simple portfolio system that uses API approach. I used MERN (SQL) stack for this.
- GitHub Repository: https://github.com/KJLumalang/ReactExpress.git

## Conclusion
This weather app demonstrates my understanding of modern web development practices, responsive design, and effective API usage. The design and code implementations prioritize user experience and maintainability.

---

Thank you for considering my project. I look forward to your feedback!