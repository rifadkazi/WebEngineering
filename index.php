<?php
session_start();

// 🔒 SECURITY CHECK:
// If the user is NOT logged in, send them to the login page immediately.
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
    <title>AgriCare - Homepage</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo">
            <img src="logos.avif" alt="AgriCare Logo">
        </a>
        <div class="navbar-tagline">Empowering Farmers with Technology</div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about-us">About</a></li>
            <li>
                <a href="#">Services</a>
                <ul class="dropdown">
                    <li><a href="crop-management.php">Crop Management</a></li>
                    <li><a href="weather-updates.php">Weather Updates</a></li>
                    <li><a href="market-insights.php">Market Insights</a></li>
                </ul>
            </li>
            <li><a href="#contact-us">Contact</a></li>
            
            <li><a href="logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>
        </ul>
    </nav>
    
    <header class="hero">
        <div class="hero-content">
            <h1>Welcome to AgriCare</h1>
            <p>Empowering sustainable farming with technology-driven solutions.</p>
            <a href="#services" class="hero-button">Explore Our Services</a>
        </div>
    </header>

    <section id="live-dashboard" style="padding: 50px; background: #f9f9f9; text-align: center;">
        <h2 style="color: #2c3e50; margin-bottom: 30px;">📡 Live Field Monitoring</h2>
        
        <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
            <div style="background: white; padding: 20px; border-radius: 10px; width: 200px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h3 style="margin: 0; color: #7f8c8d;">Temperature</h3>
                <p style="font-size: 2.5em; font-weight: bold; color: #e74c3c; margin: 10px 0;">
                    <span id="temp-display">--</span> °C
                </p>
            </div>

            <div style="background: white; padding: 20px; border-radius: 10px; width: 200px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h3 style="margin: 0; color: #7f8c8d;">Humidity</h3>
                <p style="font-size: 2.5em; font-weight: bold; color: #3498db; margin: 10px 0;">
                    <span id="hum-display">--</span> %
                </p>
            </div>

            <div style="background: white; padding: 20px; border-radius: 10px; width: 200px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h3 style="margin: 0; color: #7f8c8d;">Soil Moisture</h3>
                <p style="font-size: 2.5em; font-weight: bold; color: #27ae60; margin: 10px 0;">
                    <span id="soil-display">--</span>
                </p>
            </div>
        </div>

        <div style="max-width: 800px; margin: 40px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #2c3e50;">📈 Sensor Trends (Last 10 Readings)</h3>
            <canvas id="sensorChart"></canvas>
        </div>

        <p style="margin-top: 20px; color: #888;">Live data updating every 2 seconds...</p>
    </section>

    <section id="about-us" class="section about-us">
        <div class="about-content">
            <h2>About Us</h2>
            <p>AgriCare provides advanced technological solutions to support sustainable and efficient farming practices, delivering tools and insights that help farmers optimize their yield and improve crop management.</p>
        </div>
        <div class="about-image">
            <img src="farmer.jpg" alt="About Us Image">
        </div>
    </section>

    <section id="services" class="section services">
        <h2>Our Services</h2>
        <p>Explore the innovative solutions we provide for modern agriculture.</p>
        <div class="services-grid">
            <div class="service-card">
                <h3>Crop Management</h3>
                <p>Manage your crops efficiently with our cutting-edge tools and insights.</p>
                <a href="crop-management.php" class="service-link">Learn More</a>
            </div>
            <div class="service-card">
                <h3>Weather Updates</h3>
                <p>Stay ahead with accurate, real-time weather updates for your area.</p>
                <a href="weather-updates.php" class="service-link">Learn More</a>
            </div>
            <div class="service-card">
                <h3>Market Insights</h3>
                <p>Get detailed market analysis to make informed decisions for your business.</p>
                <a href="market-insights.php" class="service-link">Learn More</a>
            </div>
        </div>
    </section>

    <section id="contact-us" class="section contact-us">
        <h2>Contact Us</h2>
        <p>If you have any questions or need assistance, feel free to reach out!</p>
        
        <div style="max-width: 600px; margin: 0 auto; text-align: left;">
            <label for="contact-name">Your Name:</label>
            <input type="text" id="contact-name" placeholder="Kazi Hafijur Rahman Rifad" required style="width: 100%; padding: 10px; margin-bottom: 10px;">

            <label for="contact-email">Your Email:</label>
            <input type="email" id="contact-email" placeholder="rifat@example.com" required style="width: 100%; padding: 10px; margin-bottom: 10px;">

            <label for="contact-message">Message:</label>
            <textarea id="contact-message" rows="5" placeholder="How can we help?" required style="width: 100%; padding: 10px; margin-bottom: 10px;"></textarea>

            <button type="button" onclick="sendMessage()" style="padding: 10px 20px; background: #27ae60; color: white; border: none; cursor: pointer; border-radius: 5px;">
                Send Message
            </button>
            <p id="form-response" style="margin-top: 10px; font-weight: bold;"></p>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2024 AgriCare. All rights reserved.</p>
        <p style="margin-top: 10px; font-size: 0.8em;">
            <a href="reset_data.php" style="color: #e74c3c; text-decoration: none;" onclick="return confirm('Are you sure you want to delete ALL data?');">
                ⚠️ Reset System Data
            </a>
        </p>
    </footer>

    <script src="script.js"></script>

    <script>
        function sendMessage() {
            // 1. Get values
            const name = document.getElementById('contact-name').value;
            const email = document.getElementById('contact-email').value;
            const message = document.getElementById('contact-message').value;
            const responseText = document.getElementById('form-response');

            // 2. Validate
            if(name === "" || email === "" || message === "") {
                responseText.style.color = "red";
                responseText.innerText = "Please fill in all fields.";
                return;
            }

            responseText.innerText = "Sending...";

            // 3. Send to PHP
            fetch('save_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: name, email: email, message: message })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "success") {
                    responseText.style.color = "green";
                    responseText.innerText = "✅ " + data.message;
                    // Clear fields
                    document.getElementById('contact-name').value = "";
                    document.getElementById('contact-email').value = "";
                    document.getElementById('contact-message').value = "";
                } else {
                    responseText.style.color = "red";
                    responseText.innerText = "❌ " + data.message;
                }
            })
            .catch(err => {
                console.error(err);
                responseText.style.color = "red";
                responseText.innerText = "Error connecting to server.";
            });
        }
    </script>
</body>
</html>