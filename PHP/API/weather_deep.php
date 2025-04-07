<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Wizard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        /* Floating Weather Wizard */
        .weather-wizard {
            position: fixed;
            right: 20px;
            top: 20px;
            width: 300px;
            height: 400px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 1000;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .wizard-header {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .wizard-content {
            padding: 15px;
            height: calc(100% - 120px);
            overflow-y: auto;
        }
        
        .wizard-city {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #2c3e50;
            text-align: center;
        }
        
        .wizard-desc {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 15px;
            text-transform: capitalize;
        }
        
        .wizard-temp {
            font-size: 2.5rem;
            font-weight: bold;
            color: #e74c3c;
            text-align: center;
            margin: 15px 0;
        }
        
        .wizard-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .wizard-detail-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        
        .wizard-detail-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: #3498db;
        }
        
        .wizard-detail-label {
            font-size: 0.8rem;
            color: #7f8c8d;
        }
        
        .wizard-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 10px;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
        }
        
        .wizard-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .location-btn {
            background: #2ecc71;
            color: white;
        }
        
        .location-btn:hover {
            background: #27ae60;
        }
        
        .refresh-btn {
            background: #3498db;
            color: white;
        }
        
        .refresh-btn:hover {
            background: #2980b9;
        }
        
        .close-btn {
            background: #e74c3c;
            color: white;
        }
        
        .close-btn:hover {
            background: #c0392b;
        }
        
        /* Minimized state */
        .weather-wizard.minimized {
            height: 50px;
            overflow: hidden;
        }
        
        .weather-wizard.minimized .wizard-header {
            cursor: pointer;
        }
        
        .weather-wizard.minimized .wizard-content,
        .weather-wizard.minimized .wizard-footer {
            display: none;
        }
        
        /* Toggle button */
        .toggle-wizard {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Main content styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            padding-right: 340px; /* Make space for the wizard */
        }
        
        @media (max-width: 768px) {
            .weather-wizard {
                width: 280px;
                right: 10px;
            }
            
            .container {
                padding-right: 20px;
            }
        }
    </style>
</head>
<?php
    // Initialize $error to avoid undefined variable notice
    $error = $error ?? null;
?>
<body>
    <!-- Floating Weather Wizard -->
    <div class="weather-wizard" id="weatherWizard">
        <div class="wizard-header" onclick="toggleWizard()">
            Weather Wizard
        </div>
        <div class="wizard-content">
            <?php if(isset($weather) && $weather) { ?>
                <div class="wizard-city"><?php echo htmlspecialchars($_GET['city']); ?></div>
                <div class="wizard-desc"><?php echo $weatherArray['weather'][0]['description']; ?></div>
                <div class="wizard-temp"><?php echo $tempInCelcius; ?>°C</div>
                <div class="wizard-details">
                    <div class="wizard-detail-item">
                        <div class="wizard-detail-value"><?php echo $weatherArray['main']['humidity']; ?>%</div>
                        <div class="wizard-detail-label">Humidity</div>
                    </div>
                    <div class="wizard-detail-item">
                        <div class="wizard-detail-value"><?php echo $weatherArray['wind']['speed']; ?> m/s</div>
                        <div class="wizard-detail-label">Wind</div>
                    </div>
                    <div class="wizard-detail-item">
                        <div class="wizard-detail-value"><?php echo intval($weatherArray['main']['feels_like'] - 273.15); ?>°C</div>
                        <div class="wizard-detail-label">Feels Like</div>
                    </div>
                    <div class="wizard-detail-item">
                        <div class="wizard-detail-value"><?php echo $weatherArray['main']['pressure']; ?> hPa</div>
                        <div class="wizard-detail-label">Pressure</div>
                    </div>
                </div>
            <?php } else { ?>
                <div style="text-align: center; padding: 30px 0;">
                    <p>No weather data available</p>
                    <p>Search for a city or use your location</p>
                </div>
            <?php } ?>
        </div>
        <div class="wizard-footer">
            <button class="wizard-btn location-btn" onclick="getLocation()">
                <i class="fas fa-location-arrow"></i> Location
            </button>
            <button class="wizard-btn refresh-btn" onclick="refreshWeather()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <button class="wizard-btn close-btn" onclick="minimizeWizard()">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    
    <!-- Toggle Button (only shown when wizard is minimized) -->
    <button class="toggle-wizard" id="toggleWizardBtn" style="display: none;" onclick="showWizard()">
        <i class="fas fa-cloud-sun"></i>
    </button>
    
    <!-- Main Content -->
    <div class="container">
        <div class="header">
            <h1>Weather Application</h1>
            <p>Main content goes here</p>
        </div>
        
        <!-- Your existing content can go here -->
        <div class="datetime">
            <?php 
                $dt = new DateTime(); 
                echo $dt->format('l, F j, Y, g:i a'); 
            ?>
        </div>
        
        <form method="get" class="search-box">
            <input type="text" name="city" placeholder="Enter city name" value="<?php echo isset($_GET['city']) ? htmlspecialchars($_GET['city']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
        
        <?php if(isset($error) && $error) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
    </div>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <script>
        // Wizard control functions
        function toggleWizard() {
            const wizard = document.getElementById('weatherWizard');
            if (wizard.classList.contains('minimized')) {
                showWizard();
            } else {
                minimizeWizard();
            }
        }
        
        function minimizeWizard() {
            document.getElementById('weatherWizard').classList.add('minimized');
            document.getElementById('toggleWizardBtn').style.display = 'flex';
        }
        
        function showWizard() {
            document.getElementById('weatherWizard').classList.remove('minimized');
            document.getElementById('toggleWizardBtn').style.display = 'none';
        }
        
        // Weather functions
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        
        function showPosition(position) {
            fetch(`https://api.openweathermap.org/geo/1.0/reverse?lat=${position.coords.latitude}&lon=${position.coords.longitude}&limit=1&appid=e671e2ef52d67bcec7a25da21cbcfc77`)
                .then(response => response.json())
                .then(data => {
                    if(data && data.length > 0) {
                        window.location.href = window.location.pathname + `?city=${encodeURIComponent(data[0].name)}`;
                    } else {
                        alert("Could not determine city name for your location.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error fetching location data.");
                });
        }
        
        function refreshWeather() {
            const city = "<?php echo isset($_GET['city']) ? addslashes($_GET['city']) : ''; ?>";
            if(city) {
                window.location.href = window.location.pathname + `?city=${encodeURIComponent(city)}`;
            } else {
                getLocation();
            }
        }
        
        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
        
        // Initialize wizard
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(!isset($_GET['city'])): ?>
                // Auto-get location if no city is specified
                getLocation();
            <?php endif; ?>
        });
    </script>
</body>
</html>