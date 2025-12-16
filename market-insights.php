<?php
session_start();

// 🔒 SECURITY CHECK
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
    <title>Market Insights</title>
    <link rel="stylesheet" href="market-insights.css">
    <style>
        /* NEW STYLES FOR DYNAMIC SECTIONS */
        .market-dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* LIVE TICKER STYLES */
        .ticker-panel {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-top: 5px solid #e74c3c;
        }
        .ticker-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            font-size: 1.1em;
        }
        .up { color: #27ae60; font-weight: bold; }   /* Green arrow */
        .down { color: #e74c3c; font-weight: bold; } /* Red arrow */

        /* MARKETPLACE FORM STYLES */
        .marketplace-panel {
            flex: 2;
            min-width: 400px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-top: 5px solid #27ae60;
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
        input { padding: 10px; border: 1px solid #ddd; border-radius: 5px; width: 100%; box-sizing: border-box; }
        .btn-sell {
            width: 100%; padding: 12px; background: #27ae60; color: white; 
            border: none; border-radius: 5px; cursor: pointer; font-size: 1em;
        }
        .btn-sell:hover { background: #2ecc71; }

        /* LISTINGS TABLE */
        .listings-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .listings-table th { background: #34495e; color: white; padding: 10px; text-align: left; }
        .listings-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .badge { background: #eefbf3; color: #27ae60; padding: 5px 10px; border-radius: 15px; font-weight: bold; }
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
            <h1>Actionable Market Insights</h1>
            <p>Make informed decisions with real-time market trends and price predictions.</p>
        </div>
    </header>

    <section id="features" class="features">
        <h2>Why Choose Us?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <img src="market-trends.jpg" alt="Market Trends">
                <h3>Market Trends</h3>
                <p>Stay ahead with the latest market price trends and forecasts.</p>
            </div>
            <div class="feature-card">
                <img src="price-predictions.png" alt="Price Predictions">
                <h3>Price Predictions</h3>
                <p>Make better selling decisions with accurate price predictions.</p>
            </div>
            <div class="feature-card">
                <img src="demand-analysis.png" alt="Demand Analysis">
                <h3>Demand Analysis</h3>
                <p>Understand demand patterns to optimize your sales strategy.</p>
            </div>
        </div>
    </section>

    <section id="market-dashboard" class="market-dashboard">
        
        <div class="ticker-panel">
            <h2>📉 Live Global Rates</h2>
            <p style="color: #777; font-size: 0.9em;">Updates every 3 seconds</p>
            <div id="ticker-box">
                </div>
        </div>

        <div class="marketplace-panel">
            <h2>🤝 Sell Your Harvest</h2>
            <p>Post your crops for sale directly to buyers.</p>
            
            <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                <div class="form-grid">
                    <input type="text" id="farmer" placeholder="Your Name">
                    <input type="text" id="crop" placeholder="Crop (e.g. Rice)">
                </div>
                <div class="form-grid">
                    <input type="text" id="qty" placeholder="Quantity (e.g. 1 Ton)">
                    <input type="text" id="price" placeholder="Price ($)">
                </div>
                <input type="text" id="contact" placeholder="Phone Number" style="margin-bottom: 10px;">
                <button class="btn-sell" onclick="postAd()">📢 Post Listing</button>
            </div>

            <h3>Recent Listings</h3>
            <table class="listings-table">
                <thead>
                    <tr>
                        <th>Crop</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Farmer Contact</th>
                    </tr>
                </thead>
                <tbody id="listings-body">
                    </tbody>
            </table>
        </div>
    </section>

    <section id="testimonials" class="testimonials">
        <h2>What Our Clients Say</h2>
        <div class="testimonial-grid">
            <div class="testimonial">
                <p>"AgriCare's market insights helped us plan and price our harvest perfectly!"</p>
                <h4>- Farmer A</h4>
            </div>
            <div class="testimonial">
                <p>"Thanks to the accurate price predictions, we sold at the right time and maximized profit."</p>
                <h4>- Farmer B</h4>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2024 AgriCare. All rights reserved.</p>
    </footer>

    <script>
        // --- PART 1: LIVE PRICE TICKER (SIMULATION) ---
        const crops = [
            { name: "Wheat", base: 320 },
            { name: "Corn", base: 240 },
            { name: "Rice", base: 450 },
            { name: "Soybean", base: 500 },
            { name: "Potato", base: 180 }
        ];

        function updateTicker() {
            const box = document.getElementById('ticker-box');
            box.innerHTML = ""; // Clear old prices

            crops.forEach(crop => {
                // Random fluctuation between -5 and +5
                const change = Math.floor(Math.random() * 11) - 5; 
                const currentPrice = crop.base + change;
                
                let icon = "➖";
                let style = "color: grey";

                if (change > 0) { icon = "⬆"; style = "up"; }
                if (change < 0) { icon = "⬇"; style = "down"; }

                box.innerHTML += `
                    <div class="ticker-item">
                        <span>${crop.name}</span>
                        <span class="${style}">$${currentPrice} ${icon}</span>
                    </div>
                `;
            });
        }
        setInterval(updateTicker, 3000); // Run every 3 seconds
        updateTicker(); // Run immediately

        // --- PART 2: MARKETPLACE (DATABASE) ---
        function postAd() {
            const data = {
                farmer_name: document.getElementById('farmer').value,
                crop_name: document.getElementById('crop').value,
                quantity: document.getElementById('qty').value,
                price: document.getElementById('price').value,
                contact: document.getElementById('contact').value
            };

            if(!data.farmer_name || !data.crop_name) { alert("Please fill all fields"); return; }

            fetch('save_listing.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                alert(response.message);
                loadListings(); // Refresh list
                document.getElementById('crop').value = ""; // Clear input
            });
        }

        function loadListings() {
            fetch('get_listings.php')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('listings-body');
                tbody.innerHTML = "";
                data.forEach(row => {
                    tbody.innerHTML += `
                        <tr>
                            <td><b>${row.crop_name}</b></td>
                            <td>${row.quantity}</td>
                            <td><span class="badge">$${row.price}</span></td>
                            <td>${row.farmer_name}<br><small>📞 ${row.contact}</small></td>
                        </tr>
                    `;
                });
            });
        }
        loadListings(); // Load on startup
    </script>
</body>
</html>