<?php
session_start();

// 🔒 SECURITY CHECK
// If the user is NOT logged in, send them to login.php
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Updates</title>
    <link rel="stylesheet" href="weather-updates.css">
    <style>
        /* Add some styles for the search box */
        .search-container {
            text-align: center;
            margin: 20px 0;
        }
        #city-input {
            padding: 10px;
            width: 250px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        #search-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #search-btn:hover { background-color: #2ecc71; }
        
        .weather-details {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .weather-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            width: 150px;
        }
        .weather-item h3 { margin-bottom: 10px; color: #555; font-size: 0.9em; }
        .weather-item p { font-size: 1.5em; font-weight: bold; color: #333; margin: 0; }
        .error-msg { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="crop-management.php">Crop Management</a></li>
            <li><a href="weather-updates.php">Weather Updates</a></li> 
            <li><a href="market-insights.php">Market Insights</a></li>
            
            <li style="float: right;"><a href="logout.php" style="color: #e74c3c;">Logout</a></li>
        </ul>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Weather Updates</h1>
            <p>Stay informed with real-time weather data for better crop management.</p>
        </div>
    </header>

    <section id="todays-weather" class="todays-weather">
        <h2 style="text-align: center; margin-top: 40px;">Check Real-Time Weather</h2>
        
        <div class="search-container">
            <input type="text" id="city-input" placeholder="Enter City Name (e.g. Dhaka)">
            <button id="search-btn" onclick="getWeather()">Get Weather</button>
            <p id="error-message" class="error-msg"></p>
        </div>

        <div class="weather-details" id="weather-display" style="display: none;">
            <div class="weather-item">
                <h3>Location</h3>
                <p id="city-name">--</p>
            </div>
            <div class="weather-item">
                <h3>Temperature</h3>
                <p id="temp">--°C</p>
            </div>
            <div class="weather-item">
                <h3>Condition</h3>
                <p id="condition">--</p>
            </div>
            <div class="weather-item">
                <h3>Humidity</h3>
                <p id="humidity">--%</p>
            </div>
             <div class="weather-item">
                <h3>Wind Speed</h3>
                <p id="wind">-- km/h</p>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <h2>Weather Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <img src="forecast.jpg" alt="Weather Forecast">
                <h3>Weather Forecast</h3>
                <p>Get daily and weekly weather predictions.</p>
            </div>
            <div class="feature-card">
                <img src="alerts.jpg" alt="Weather Alerts">
                <h3>Weather Alerts</h3>
                <p>Receive instant alerts for severe weather conditions.</p>
            </div>
            <div class="feature-card">
                <img src="rainfall.jpg" alt="Rainfall Data">
                <h3>Rainfall Data</h3>
                <p>Monitor rainfall levels to optimize irrigation.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2024 AgriCare. All rights reserved.</p>
    </footer>

    <script>
        const apiKey = "1635890035cbba097fd5c26c8ea672a1"; 

        function getWeather() {
            const city = document.getElementById('city-input').value;
            const errorMsg = document.getElementById('error-message');
            const display = document.getElementById('weather-display');

            if (city === "") {
                errorMsg.innerText = "Please enter a city name.";
                return;
            }

            // API URL
            const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.cod === "404") {
                        errorMsg.innerText = "City not found! Please check spelling.";
                        display.style.display = "none";
                    } else {
                        errorMsg.innerText = "";
                        display.style.display = "flex";

                        // Update HTML with Data
                        document.getElementById('city-name').innerText = data.name + ", " + data.sys.country;
                        document.getElementById('temp').innerText = Math.round(data.main.temp) + "°C";
                        document.getElementById('condition').innerText = data.weather[0].main;
                        document.getElementById('humidity').innerText = data.main.humidity + "%";
                        document.getElementById('wind').innerText = data.wind.speed + " km/h";
                    }
                })
                .catch(error => {
                    console.error("Error fetching weather:", error);
                    errorMsg.innerText = "Error connecting to weather service.";
                });
        }

        // --- ENABLE "ENTER" KEY ---
        document.getElementById("city-input").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("search-btn").click();
            }
        });
    </script>
</body>
</html>