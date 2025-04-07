document.addEventListener('DOMContentLoaded', function() {
    // Default location
    let currentLocation = "New York";
    
    // DOM Elements
    const locationSearch = document.getElementById('location-search');
    const refreshBtn = document.getElementById('refresh-btn');
    const locationBtn = document.getElementById('location-btn');
    
    // Weather elements
    const currentCity = document.getElementById('current-city');
    const currentTemp = document.getElementById('current-temp');
    const currentIcon = document.getElementById('current-icon');
    const currentDesc = document.getElementById('current-desc');
    const currentWind = document.getElementById('current-wind');
    const currentHumidity = document.getElementById('current-humidity');
    const currentPressure = document.getElementById('current-pressure');
    
    // AQI elements
    const aqiValue = document.getElementById('aqi-value');
    const aqiDesc = document.getElementById('aqi-desc');
    const pm25 = document.getElementById('pm25');
    const pm10 = document.getElementById('pm10');
    const ozone = document.getElementById('ozone');
    
    // Sun elements
    const sunrise = document.getElementById('sunrise');
    const sunset = document.getElementById('sunset');
    
    // UV elements
    const uvIndex = document.getElementById('uv-index');
    const uvDesc = document.getElementById('uv-desc');
    
    // Visibility
    const visibility = document.getElementById('visibility');
    
    // Forecast containers
    const hourlyForecast = document.getElementById('hourly-forecast');
    const dailyForecast = document.getElementById('daily-forecast');
    
    // Wizard elements
    const wizardMessage = document.getElementById('wizard-message');
    const wizardTemp = document.getElementById('wizard-temp');
    const wizardIcon = document.getElementById('wizard-icon');
    const wizardLocation = document.getElementById('wizard-location');
    const wizardTip = document.getElementById('wizard-tip');
    
    // Initialize the app
    fetchWeatherData(currentLocation);
    
    // Event listeners
    locationSearch.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            currentLocation = this.value;
            fetchWeatherData(currentLocation);
            this.value = '';
        }
    });
    
    refreshBtn.addEventListener('click', function() {
        fetchWeatherData(currentLocation);
        wizardMessage.textContent = "Refreshing weather data...";
    });
    
    locationBtn.addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    fetchWeatherByCoords(lat, lon);
                    wizardMessage.textContent = "Getting weather for your current location...";
                },
                error => {
                    console.error("Error getting location:", error);
                    wizardMessage.textContent = "Couldn't get your location. Please enable location services or search manually.";
                }
            );
        } else {
            wizardMessage.textContent = "Geolocation is not supported by your browser. Please search manually.";
        }
    });
    
    // Fetch weather data
    function fetchWeatherData(location) {
        wizardMessage.textContent = `Fetching weather data for ${location}...`;
        
        // In a real app, you would call your PHP API endpoint here
        // For this example, we'll use mock data
        setTimeout(() => {
            updateWeatherUI(getMockWeatherData());
            wizardMessage.textContent = getRandomWizardMessage();
        }, 1000);
    }
    
    function fetchWeatherByCoords(lat, lon) {
        // In a real app, you would call your PHP API endpoint with coordinates
        // For this example, we'll use mock data
        setTimeout(() => {
            const mockData = getMockWeatherData();
            mockData.location = "Your Location";
            updateWeatherUI(mockData);
            wizardMessage.textContent = getRandomWizardMessage();
        }, 1000);
    }
    
    // Update UI with weather data
    function updateWeatherUI(data) {
        // Current weather
        currentCity.textContent = data.location;
        currentTemp.textContent = data.current.temp;
        currentIcon.src = getWeatherIcon(data.current.condition);
        currentDesc.textContent = data.current.desc;
        currentWind.textContent = data.current.wind;
        currentHumidity.textContent = data.current.humidity;
        currentPressure.textContent = data.current.pressure;
        
        // AQI
        aqiValue.textContent = data.aqi.value;
        aqiValue.style.color = getAqiColor(data.aqi.value);
        aqiDesc.textContent = data.aqi.desc;
        pm25.textContent = data.aqi.pm25;
        pm10.textContent = data.aqi.pm10;
        ozone.textContent = data.aqi.ozone;
        
        // Sun times
        sunrise.textContent = data.sun.sunrise;
        sunset.textContent = data.sun.sunset;
        
        // UV index
        uvIndex.textContent = data.uv.index;
        uvIndex.style.color = getUvColor(data.uv.index);
        uvDesc.textContent = data.uv.desc;
        
        // Visibility
        visibility.textContent = data.visibility;
        
        // Hourly forecast
        hourlyForecast.innerHTML = '';
        data.hourly.forEach(hour => {
            hourlyForecast.innerHTML += `
                <div class="hourly-item">
                    <div class="time">${hour.time}</div>
                    <img src="${getWeatherIcon(hour.condition)}" alt="${hour.desc}">
                    <div class="temp">${hour.temp}°</div>
                </div>
            `;
        });
        
        // Daily forecast
        dailyForecast.innerHTML = '';
        data.daily.forEach(day => {
            dailyForecast.innerHTML += `
                <div class="col">
                    <div class="daily-item">
                        <div class="day">${day.day}</div>
                        <img src="${getWeatherIcon(day.condition)}" alt="${day.desc}">
                        <div class="desc">${day.desc}</div>
                        <div class="temps">
                            <span class="high">${day.high}°</span>
                            <span class="low">${day.low}°</span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        // Update wizard
        wizardTemp.textContent = `${data.current.temp}°F`;
        wizardIcon.src = getWeatherIcon(data.current.condition);
        wizardLocation.textContent = data.location;
        wizardTip.textContent = getWeatherTip(data.current.condition, data.current.temp);
    }
    
    // Helper functions
    function getWeatherIcon(condition) {
        const icons = {
            'sunny': 'assets/icons/sunny.png',
            'cloudy': 'assets/icons/cloudy.png',
            'rain': 'assets/icons/rain.png',
            'snow': 'assets/icons/snow.png',
            'thunderstorm': 'assets/icons/thunderstorm.png',
            'partly-cloudy': 'assets/icons/partly-cloudy.png',
            'windy': 'assets/icons/windy.png',
            'fog': 'assets/icons/fog.png'
        };
        return icons[condition.toLowerCase()] || icons['sunny'];
    }
    
    function getAqiColor(aqi) {
        if (aqi <= 50) return '#2ecc71'; // Good
        if (aqi <= 100) return '#f1c40f'; // Moderate
        if (aqi <= 150) return '#e67e22'; // Unhealthy for sensitive
        if (aqi <= 200) return '#e74c3c'; // Unhealthy
        if (aqi <= 300) return '#9b59b6'; // Very unhealthy
        return '#c0392b'; // Hazardous
    }
    
    function getUvColor(uv) {
        if (uv <= 2) return '#2ecc71'; // Low
        if (uv <= 5) return '#f1c40f'; // Moderate
        if (uv <= 7) return '#e67e22'; // High
        if (uv <= 10) return '#e74c3c'; // Very high
        return '#9b59b6'; // Extreme
    }
    
    function getWeatherTip(condition, temp) {
        const tips = {
            'sunny': [
                "Don't forget your sunscreen today!",
                "Perfect day for outdoor activities.",
                "Stay hydrated in this sunny weather."
            ],
            'cloudy': [
                "Might want to bring an umbrella just in case.",
                "Good day for a walk in the park.",
                "Cloudy skies but no rain expected."
            ],
            'rain': [
                "Don't forget your umbrella!",
                "Perfect day to stay in with a good book.",
                "Wear waterproof shoes today."
            ],
            'snow': [
                "Dress warmly and drive safely!",
                "Great day for building a snowman.",
                "Watch out for icy patches."
            ],
            'thunderstorm': [
                "Stay indoors if possible!",
                "Unplug electronics during the storm.",
                "Avoid open areas during lightning."
            ]
        };
        
        const conditionTips = tips[condition.toLowerCase()] || ["Enjoy your day!"];
        
        // Add temperature specific tips
        if (temp < 32) {
            conditionTips.push("Bundle up, it's freezing out there!");
        } else if (temp > 85) {
            conditionTips.push("Stay cool and drink plenty of water!");
        }
        
        return conditionTips[Math.floor(Math.random() * conditionTips.length)];
    }
    
    function getRandomWizardMessage() {
        const messages = [
            "The weather spirits have spoken!",
            "By my magical forecast...",
            "According to my crystal ball...",
            "The winds tell me that...",
            "My weather spells indicate...",
            "The atmospheric energies show..."
        ];
        return messages[Math.floor(Math.random() * messages.length)];
    }
    
    // Mock data for demonstration
    function getMockWeatherData() {
        return {
            location: "New York",
            current: {
                temp: 72,
                condition: "sunny",
                desc: "Sunny",
                wind: 5,
                humidity: 45,
                pressure: 1012
            },
            aqi: {
                value: 45,
                desc: "Good",
                pm25: 12,
                pm10: 24,
                ozone: 32
            },
            sun: {
                sunrise: "6:45 AM",
                sunset: "7:30 PM"
            },
            uv: {
                index: 5,
                desc: "Moderate"
            },
            visibility: 10,
            hourly: [
                { time: "Now", temp: 72, condition: "sunny", desc: "Sunny" },
                { time: "1 PM", temp: 74, condition: "sunny", desc: "Sunny" },
                { time: "2 PM", temp: 75, condition: "partly-cloudy", desc: "Partly Cloudy" },
                { time: "3 PM", temp: 76, condition: "partly-cloudy", desc: "Partly Cloudy" },
                { time: "4 PM", temp: 75, condition: "partly-cloudy", desc: "Partly Cloudy" },
                { time: "5 PM", temp: 73, condition: "partly-cloudy", desc: "Partly Cloudy" },
                { time: "6 PM", temp: 70, condition: "cloudy", desc: "Cloudy" },
                { time: "7 PM", temp: 68, condition: "cloudy", desc: "Cloudy" },
                { time: "8 PM", temp: 65, condition: "cloudy", desc: "Cloudy" }
            ],
            daily: [
                { day: "Today", high: 76, low: 65, condition: "sunny", desc: "Sunny" },
                { day: "Tue", high: 78, low: 66, condition: "partly-cloudy", desc: "Partly Cloudy" },
                { day: "Wed", high: 80, low: 68, condition: "partly-cloudy", desc: "Partly Cloudy" },
                { day: "Thu", high: 82, low: 70, condition: "sunny", desc: "Sunny" },
                { day: "Fri", high: 75, low: 67, condition: "rain", desc: "Rain" }
            ]
        };
    }
});