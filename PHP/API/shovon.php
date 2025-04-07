<?php
error_reporting(0);

$weather = "";
$error = "";
$background = "default.jpg";
$dt = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

// Function to get weather data
function getWeatherData($city) {
    $url = "https://api.openweathermap.org/data/2.5/weather?q=".urlencode($city)."&appid=e1765d3650821012139f2699a4d12cef";
    $urlContent = file_get_contents($url);
    return json_decode($urlContent, true);
}

// Function to get weather by coordinates
function getWeatherByCoordinates($lat, $lon) {
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$lon."&appid=e1765d3650821012139f2699a4d12cef";
    $urlContent = file_get_contents($url);
    return json_decode($urlContent, true);
}

// Check if city search was submitted
if(isset($_GET['city'])) {
    $weatherArray = getWeatherData($_GET['city']);
    
    if($weatherArray['cod'] == 200) {
        $currentWeather = processWeatherData($weatherArray);
        $weather = $currentWeather['html'];
        $background = $currentWeather['background'];
        $searchedCity = $_GET['city'];
    } else {
        $error = "<div class='alert alert-danger'>Couldn't find the city - Please try again</div>";
    }
}

// Process weather data
function processWeatherData($weatherArray) {
    global $dt;
    
    $weatherIcon = $weatherArray['weather'][0]['icon'];
    $weatherMain = strtolower($weatherArray['weather'][0]['main']);
    $weatherDescription = strtolower($weatherArray['weather'][0]['description']);
    $tempInCelcius = intval($weatherArray['main']['temp'] - 273.15);
    $humidity = $weatherArray['main']['humidity'];
    $windSpeed = $weatherArray['wind']['speed'];
    
    // Set background based on weather condition
    $backgroundMap = [
        'rain' => 'Rain.jpg',
        'tornado' => 'Tornado.jpg',
        'wind' => 'Wind.jpg',
        'clouds' => 'Cloudy.gif',
        'snow' => 'Snow.jpg',
        'fog' => 'Fog.jpg',
        'mist' => 'Fog.jpg',
        'haze' => 'Fog.jpg',
        'hail' => 'Hail.jpg',
        'sleet' => 'Sleet.jpg',
        'thunderstorm' => 'Thunderstorm.jpg',
        'drizzle' => 'Drizzle.jpg',
        'clear' => 'Sunny.jpg',
        'extreme' => 'Winter storm.jpg',
        'blizzard' => 'Blizzard.jpg',
        'cold' => 'Cold.jpg',
        'lightning' => 'Lightning.jpg',
        'frost' => 'Frost.jpg',
        'hurricane' => 'Hurricane.jpg',
        'typhoon' => 'Hurricanes and typhoons.jpg',
        'partly cloudy' => 'Partially cloudy.jpg',
        'storm' => 'Stormy.jpg'
    ];
    
    $background = 'default.jpg';
    foreach ($backgroundMap as $condition => $bgImage) {
        if (strpos($weatherDescription, $condition) !== false || strpos($weatherMain, $condition) !== false) {
            $background = $bgImage;
            break;
        }
    }
    
    $html = "<div class='weather-result'>
                <div class='weather-main-info'>
                    <div class='weather-temp'>
                        <span class='temperature'>{$tempInCelcius}&deg;C</span>
                        <div class='weather-condition'>".ucwords($weatherArray['weather'][0]['description'])."</div>
                    </div>
                    <img src='https://openweathermap.org/img/wn/{$weatherIcon}@4x.png' alt='Weather icon' class='weather-icon'>
                </div>
                <div class='weather-details'>
                    <div><span>Humidity:</span> {$humidity}%</div>
                    <div><span>Wind Speed:</span> {$windSpeed} m/s</div>
                    <div><span>Pressure:</span> {$weatherArray['main']['pressure']} hPa</div>
                    <div><span>Visibility:</span> ". (isset($weatherArray['visibility']) ? ($weatherArray['visibility'] / 1000) . ' km' : 'N/A') . "</div>
                </div>
            </div>";
    
    return ['html' => $html, 'background' => $background];
}

// Try to get auto-detected location weather if no search was made
if(!isset($searchedCity)) {
    // In a real implementation, you would use JavaScript to get the user's location
    // For demo purposes, we'll simulate it with a default location
    $defaultLat = 23.8103;  // Default to Dhaka coordinates
    $defaultLon = 90.4125;
    
    $weatherArray = getWeatherByCoordinates($defaultLat, $defaultLon);
    if($weatherArray['cod'] == 200) {
        $currentWeather = processWeatherData($weatherArray);
        $localWeather = $currentWeather['html'];
        $background = $currentWeather['background'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
            background-color: #f5f5f5;
        }
        
        /* Navigation */
        .navbar {
            border-radius: 0;
            margin-bottom: 0;
            background-color: rgba(44, 62, 80, 0.9);
            border: none;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: rgb(237, 236, 241) !important;
            font-size: 22px;
        }
        
        /* Hero Section with Dynamic Background */
        .hero {
            position: relative;
            height: 60vh;
            min-height: 400px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            transition: opacity 1s ease-in-out;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        /* Search Form */
        .search-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-form .form-control {
            height: 50px;
            font-size: 18px;
            padding: 10px 15px;
        }
        
        .search-form .btn {
            height: 50px;
            font-size: 18px;
            padding: 10px 30px;
        }
        
        /* Local Weather Widget */
        .local-weather {
            position: absolute;
            top: 80px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            padding: 15px;
            color: white;
            z-index: 1000;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .local-weather-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 8px;
        }
        
        .local-weather-main {
            display: flex;
            align-items: center;
        }
        
        .local-weather-icon {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        
        .local-weather-temp {
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        /* Weather Results */
        .weather-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            margin-top: -50px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .weather-result {
            text-align: center;
        }
        
        .weather-main-info {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .weather-temp {
            margin-right: 20px;
        }
        
        .temperature {
            font-size: 3.5rem;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .weather-condition {
            font-size: 1.5rem;
            color: #7f8c8d;
        }
        
        .weather-icon {
            width: 120px;
            height: 120px;
        }
        
        .weather-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            text-align: left;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .weather-details div {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .weather-details span {
            font-weight: bold;
            color: #2c3e50;
        }
        
        /* Footer */
        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero {
                height: 50vh;
                min-height: 300px;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .local-weather {
                position: static;
                width: 100%;
                margin-bottom: 20px;
                border-radius: 0;
            }
            
            .weather-main-info {
                flex-direction: column;
            }
            
            .weather-temp {
                margin-right: 0;
                margin-bottom: 15px;
                text-align: center;
            }
            
            .weather-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Weather Forecast</a>
            </div>
        </div>
    </nav>
    
    <!-- Local Weather Widget (Top Corner) -->
    <?php if(isset($localWeather)): ?>
    <div class="local-weather">
        <div class="local-weather-header">
            <h4>Your Location</h4>
            <span><?php echo $dt->format('g:i a'); ?></span>
        </div>
        <div class="local-weather-main">
            <img src="https://openweathermap.org/img/wn/<?php echo $weatherArray['weather'][0]['icon']; ?>@2x.png" alt="Weather icon" class="local-weather-icon">
            <div>
                <div class="local-weather-temp"><?php echo intval($weatherArray['main']['temp'] - 273.15); ?>&deg;C</div>
                <div><?php echo ucwords($weatherArray['weather'][0]['description']); ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Hero Section with Search -->
    <section class="hero">
        <img src="<?php echo $background; ?>" alt="Weather background" class="hero-bg">
        
        <div class="hero-content">
            <h1>Weather Forecast</h1>
            
            <form method="get" class="search-form">
                <div class="form-group">
                    <input type="text" name="city" class="form-control" placeholder="Enter city name" value="<?php echo isset($searchedCity) ? htmlspecialchars($searchedCity) : ''; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Get Weather</button>
            </form>
        </div>
    </section>
    
    <!-- Main Weather Results -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($weather)): ?>
                    <div class="weather-container">
                        <h2 class="text-center">Weather in <?php echo htmlspecialchars($searchedCity); ?></h2>
                        <?php echo $weather; ?>
                        
                        <h3 class="text-center" style="margin-top: 30px;">5-Day Forecast</h3>
                        <div class="row text-center forecast">
                            <?php 
                            // Sample forecast data - in a real app you'd get this from the API
                            $forecastDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                            $forecastIcons = ['01d', '02d', '03d', '09d', '10d'];
                            $forecastTemps = [28, 26, 24, 22, 20];
                            
                            for ($i = 0; $i < 5; $i++): ?>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div><?php echo $forecastDays[$i]; ?></div>
                                    <img src="https://openweathermap.org/img/wn/<?php echo $forecastIcons[$i]; ?>@2x.png" width="60">
                                    <div><?php echo $forecastTemps[$i]; ?>°C</div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php elseif(isset($error)): ?>
                    <div class="weather-container">
                        <?php echo $error; ?>
                    </div>
                <?php else: ?>
                    <div class="weather-container">
                        <h2 class="text-center">How to Use This Weather App</h2>
                        <p class="text-center">Enter a city name in the search box above to get current weather conditions and forecast.</p>
                        
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-6">
                                <h3>Current Features</h3>
                                <ul>
                                    <li>Real-time weather data</li>
                                    <li>Auto-detected local weather</li>
                                    <li>5-day forecast</li>
                                    <li>Detailed weather information</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3>Weather Types</h3>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <img src="Sunny.jpg" class="img-thumbnail" style="width:100%">
                                        <div class="text-center">Sunny</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <img src="Rain.jpg" class="img-thumbnail" style="width:100%">
                                        <div class="text-center">Rain</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Weather Forecast App. All rights reserved.</p>
            <p>Weather data provided by OpenWeatherMap</p>
        </div>
    </footer>

    <script>
        // In a real implementation, you would use this JavaScript to get the user's actual location
        /*
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // Send coordinates to server to get weather
                    window.location.href = `?lat=${position.coords.latitude}&lon=${position.coords.longitude}`;
                },
                function(error) {
                    console.error("Error getting location: ", error);
                    // Fallback to default location
                }
            );
        } else {
            // Geolocation not supported
        }
        */
    </script>
</body>
</html>