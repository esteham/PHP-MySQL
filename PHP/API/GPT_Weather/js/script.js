document.addEventListener("DOMContentLoaded", () => {
  const apiKey = "YOUR_API_KEY";
  const city = "London"; // You can dynamically change this with PHP

  fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${e671e2ef52d67bcec7a25da21cbcfc77}`)
    .then(res => res.json())
    .then(data => {
      const weatherHTML = `
        <p><strong>City:</strong> ${data.name}</p>
        <p><strong>Temperature:</strong> ${data.main.temp}°C</p>
        <p><strong>Condition:</strong> ${data.weather[0].description}</p>
      `;
      document.getElementById("wizard-weather").innerHTML = weatherHTML;
      document.getElementById("weather-details").innerHTML = `
        <h4>Details for ${data.name}</h4>
        <ul>
          <li>Humidity: ${data.main.humidity}%</li>
          <li>Wind: ${data.wind.speed} m/s</li>
          <li>Pressure: ${data.main.pressure} hPa</li>
        </ul>
      `;
    })
    .catch(err => {
      console.error(err);
      document.getElementById("wizard-weather").innerText = "Error loading weather data.";
    });
});
