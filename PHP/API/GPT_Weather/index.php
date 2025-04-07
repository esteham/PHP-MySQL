<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Weather Wizard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row min-vh-100">
      <!-- Left side: General Weather Info -->
      <div class="col-md-8 p-5 bg-light">
        <h1 class="mb-4">🌦️ Weather Wizard Home</h1>
        <div id="weather-details" class="mb-3">
          <!-- Weather details will go here -->
        </div>
        <p>Stay updated with the latest weather conditions and forecasts.</p>
      </div>

      <!-- Right side: Wizard Style Weather -->
      <div class="col-md-4 p-5 bg-dark text-white d-flex align-items-center justify-content-center">
        <div class="wizard-card text-center">
          <h2>🧙 Weather Panel</h2>
          <div id="wizard-weather">
            Loading...
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
