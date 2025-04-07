<?php

error_reporting(0);

$weather = "";
$error = "";

$dt = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

if($_GET['city'])
{
	$urlContent = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".urlencode($_GET['city'])."&appid=e671e2ef52d67bcec7a25da21cbcfc77");

	$weatherArray = json_decode( $urlContent, true);

	if($weatherArray['cod'] == 200)
	{
		$weather = "The weather in:".$_GET['city']."is currently'".$weatherArray['weather'][0]['description']."'.";

		$tempInCelcius = intval($weatherArray['main']['temp'] - 273.15);

		$weather.="The Temparature is:".$tempInCelcius."&deg;C and wind speed is :".$weatherArray['wind']['speed']." m/s.";
	}

	else
	{
		$error = "Couldn't find the city-Please try again";
	}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Forecast</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        /* Navbar Styles */
        nav {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            right: .2px;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
        
        }

        nav .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #00f2fe;
        }

        .weather-card {
            position: fixed;
            top: 100px;
            right: 30px;
            width: 300px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .weather-card h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .weather-card form {
            margin-bottom: 15px;
        }

        .weather-card input[type="text"] {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .weather-card button {
            width: 100%;
            padding: 8px;
            background: white;
            color: #0077ff;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .weather-info {
            text-align: center;
        }

        .weather-info img {
            width: 60px;
            height: 60px;
        }

        .error {
            color: #ffe5e5;
            text-align: center;
        }

        main {
            padding-top: 80px;
            padding-left: 30px;
            max-width: 700px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.6);
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="logo">🌍 MyWeather</div>
    <ul>
        <li><a href="#">🏠 Home</a></li>
        <li><a href="#">🌦️ Weather</a></li>
        <li><a href="#">📰 News</a></li>
        <li><a href="#">📞 Contact</a></li>
    </ul>
</nav>

<!-- Main Content -->
<main>
    <h1>Welcome to Live Weather!</h1>
    <p>Check your city’s weather or use the search bar in the widget on the right.</p>
</main>



<!-- Weather Widget -->
<div class="weather-card">
    <form method="GET">
        <input type="text" name="city" placeholder="Enter city name" value="<?= htmlspecialchars($_GET['city'] ?? '') ?>">
        <button type="submit">Get Weather</button>
    </form>

    <?php if ($weather): ?>
        <div class="weather-info">
            <h2><?= htmlspecialchars($_GET['city']) ?></h2>
            <p><?= $weather ?></p>
        </div>
    <?php elseif ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
</div>

<!-- Footer -->
<footer>
    &copy; <?= date('Y') ?> MyWeather | Powered by SpiDer
</footer>

</body>
</html>
