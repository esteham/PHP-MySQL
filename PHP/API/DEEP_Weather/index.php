<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Wizard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content Area (75% width) -->
            <div class="col-lg-9 main-content">
                <header class="py-4">
                    <h1 class="text-center">Weather Wizard</h1>
                    <div class="search-bar text-center mt-3">
                        <input type="text" id="location-search" class="form-control w-50 mx-auto" placeholder="Search for a location...">
                    </div>
                </header>

                <div class="current-weather">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card today-weather">
                                <div class="card-body">
                                    <h2 id="current-city">New York</h2>
                                    <div class="weather-main">
                                        <div class="temperature">
                                            <span id="current-temp">72</span>°F
                                        </div>
                                        <div class="weather-icon">
                                            <img id="current-icon" src="assets/icons/sunny.png" alt="Sunny">
                                        </div>
                                    </div>
                                    <div class="weather-desc" id="current-desc">Sunny</div>
                                    <div class="weather-details">
                                        <div><i class="fas fa-wind"></i> <span id="current-wind">5</span> mph</div>
                                        <div><i class="fas fa-tint"></i> <span id="current-humidity">45</span>%</div>
                                        <div><i class="fas fa-compress-alt"></i> <span id="current-pressure">1012</span> hPa</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card air-quality">
                                <div class="card-body">
                                    <h3>Air Quality</h3>
                                    <div class="aqi-value" id="aqi-value">45</div>
                                    <div class="aqi-desc" id="aqi-desc">Good</div>
                                    <div class="aqi-details">
                                        <div>PM2.5: <span id="pm25">12</span> µg/m³</div>
                                        <div>PM10: <span id="pm10">24</span> µg/m³</div>
                                        <div>Ozone: <span id="ozone">32</span> µg/m³</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hourly-forecast mt-4">
                    <h3>Hourly Forecast</h3>
                    <div class="scroll-container">
                        <div class="hourly-items" id="hourly-forecast">
                            <!-- Filled by JavaScript -->
                        </div>
                    </div>
                </div>

                <div class="daily-forecast mt-4">
                    <h3>5-Day Forecast</h3>
                    <div class="row" id="daily-forecast">
                        <!-- Filled by JavaScript -->
                    </div>
                </div>

                <div class="weather-details mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Sunrise & Sunset</h4>
                                    <div class="sun-times">
                                        <div><i class="fas fa-sunrise"></i> <span id="sunrise">6:45 AM</span></div>
                                        <div><i class="fas fa-sunset"></i> <span id="sunset">7:30 PM</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4>UV Index</h4>
                                    <div class="uv-index">
                                        <div class="uv-value" id="uv-index">5</div>
                                        <div class="uv-desc" id="uv-desc">Moderate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Visibility</h4>
                                    <div class="visibility">
                                        <span id="visibility">10</span> miles
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weather Wizard Sidebar (25% width) -->
            <div class="col-lg-3 weather-wizard">
                <div class="wizard-container">
                    <div class="wizard-header">
                        <h2>Weather Wizard</h2>
                        <div class="wizard-avatar">
                            <img src="assets/images/wizard.png" alt="Weather Wizard">
                        </div>
                    </div>
                    <div class="wizard-message" id="wizard-message">
                        Welcome to Weather Wizard! I'll help you with weather information.
                    </div>
                    <div class="wizard-weather">
                        <div class="wizard-temp" id="wizard-temp">72°F</div>
                        <div class="wizard-icon">
                            <img id="wizard-icon" src="assets/icons/sunny.png" alt="Sunny">
                        </div>
                        <div class="wizard-location" id="wizard-location">New York</div>
                    </div>
                    <div class="wizard-tips">
                        <h4>Today's Tip</h4>
                        <p id="wizard-tip">It's a beautiful sunny day! Perfect for outdoor activities.</p>
                    </div>
                    <div class="wizard-actions">
                        <button class="btn btn-wizard" id="refresh-btn">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button class="btn btn-wizard" id="location-btn">
                            <i class="fas fa-location-arrow"></i> My Location
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>
</html>