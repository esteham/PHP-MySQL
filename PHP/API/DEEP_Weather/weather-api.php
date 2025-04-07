<?php
header('Content-Type: application/json');

// In a real application, you would connect to a weather API here
// This is a mock endpoint that returns sample data

$location = isset($_GET['location']) ? $_GET['location'] : 'New York';
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lon = isset($_GET['lon']) ? floatval($_GET['lon']) : null;

// Simulate API delay
sleep(1);

// Return mock data
echo json_encode([
    'location' => $location,
    'current' => [
        'temp' => rand(60, 90),
        'condition' => ['sunny', 'cloudy', 'rain', 'partly-cloudy'][rand(0, 3)],
        'desc' => ['Sunny', 'Cloudy', 'Rainy', 'Partly Cloudy'][rand(0, 3)],
        'wind' => rand(0, 15),
        'humidity' => rand(30, 80),
        'pressure' => rand(1000, 1020)
    ],
    'forecast' => [
        'hourly' => array_map(function() {
            return [
                'time' => date('g A', mktime(rand(0, 23), 0, 0)),
                'temp' => rand(60, 85),
                'condition' => ['sunny', 'cloudy', 'rain', 'partly-cloudy'][rand(0, 3)],
                'desc' => ['Sunny', 'Cloudy', 'Rainy', 'Partly Cloudy'][rand(0, 3)]
            ];
        }, range(0, 7)),
        'daily' => array_map(function($i) {
            return [
                'day' => date('D', strtotime("+$i days")),
                'high' => rand(70, 90),
                'low' => rand(60, 70),
                'condition' => ['sunny', 'cloudy', 'rain', 'partly-cloudy'][rand(0, 3)],
                'desc' => ['Sunny', 'Cloudy', 'Rainy', 'Partly Cloudy'][rand(0, 3)]
            ];
        }, range(0, 4))
    ],
    'aqi' => [
        'value' => rand(10, 80),
        'desc' => ['Good', 'Moderate', 'Unhealthy for Sensitive Groups'][rand(0, 2)],
        'pm25' => rand(5, 30),
        'pm10' => rand(10, 40),
        'ozone' => rand(20, 50)
    ],
    'uv' => [
        'index' => rand(1, 8),
        'desc' => ['Low', 'Moderate', 'High', 'Very High'][rand(0, 3)]
    ],
    'sun' => [
        'sunrise' => date('g:i A', mktime(6, rand(0, 59), 0)),
        'sunset' => date('g:i A', mktime(18, rand(0, 59), 0))
    ],
    'visibility' => rand(5, 15)
]);
?>