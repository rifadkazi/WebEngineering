// ==========================================
// 1. LOGIN MODAL UI LOGIC (Open/Close)
// ==========================================

// Get elements
var modal = document.getElementById("login-modal");
var loginBtn = document.getElementById("login-btn");
var closeModal = document.getElementById("close-modal");

// Only run this if the login button exists on the current page
if (loginBtn) {
    // Open modal
    loginBtn.onclick = function() {
        if(modal) modal.style.display = "block";
    }

    // Close modal on 'X' click
    if (closeModal) {
        closeModal.onclick = function() {
            modal.style.display = "none";
        }
    }

    // Close modal if clicking outside the box
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

// ==========================================
// 2. HANDLE LOGIN FORM SUBMISSION
// ==========================================
// This sends the username/password to login.php

// Find the form inside the modal
const loginForm = document.querySelector("#login-modal form");

if (loginForm) {
    loginForm.onsubmit = function(e) {
        e.preventDefault(); // Stop page from reloading

        const usernameInput = document.getElementById("username").value;
        const passwordInput = document.getElementById("password").value;

        // Send data to PHP
        fetch('login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username: usernameInput, password: passwordInput })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("✅ Welcome back, " + data.username + "!");
                
                // Close modal
                document.getElementById("login-modal").style.display = "none";
                
                // Update the Login Button to show the user is logged in
                if(loginBtn) {
                    loginBtn.innerHTML = "👤 " + data.username;
                    loginBtn.style.color = "#2ecc71"; // Make text green
                    // Optional: Make clicking it logout
                    loginBtn.onclick = function() { 
                        if(confirm("Do you want to logout?")) location.reload(); 
                    }; 
                }
            } else {
                alert("❌ Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    };
}

// ==========================================
// 3. LIVE DASHBOARD (CARDS & GRAPH)
// ==========================================

let myChart = null; // Variable to store the chart instance

function updateDashboard() {
    // A. UPDATE SENSOR CARDS (Temp, Hum, Soil)
    // We check if the elements exist first to avoid errors on other pages
    if(document.getElementById('temp-display')) {
        fetch('read.php')
            .then(response => response.json())
            .then(data => {
                if (data) {
                    if(document.getElementById('temp-display')) 
                        document.getElementById('temp-display').innerText = data.temperature;
                    
                    if(document.getElementById('hum-display')) 
                        document.getElementById('hum-display').innerText = data.humidity;
                    
                    if(document.getElementById('soil-display')) 
                        document.getElementById('soil-display').innerText = data.soil_moisture;
                }
            })
            .catch(err => console.log("Waiting for sensor data..."));
    }

    // B. UPDATE LIVE GRAPH
    // Only run this if the chart canvas exists on this page
    if(document.getElementById('sensorChart')) {
        fetch('get_sensor_history.php')
            .then(response => response.json())
            .then(historyData => {
                updateChart(historyData);
            })
            .catch(err => console.log("Waiting for graph data..."));
    }
}

// Function to Draw/Update the Chart
function updateChart(data) {
    const ctx = document.getElementById('sensorChart').getContext('2d');
    
    // Extract data for the graph
    // We split the reading_time to just show HH:MM:SS
    const labels = data.map(item => item.reading_time.split(" ")[1]); 
    const temps = data.map(item => item.temperature);
    const hums = data.map(item => item.humidity);

    // If a chart already exists, destroy it so we can draw the new one cleanly
    if (myChart) {
        myChart.destroy();
    }

    // Create the Chart using Chart.js library
    myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Temperature (°C)',
                    data: temps,
                    borderColor: '#e74c3c', // Red Color
                    backgroundColor: 'rgba(231, 76, 60, 0.2)',
                    borderWidth: 3,
                    tension: 0.3, // Makes lines smooth
                    fill: true
                },
                {
                    label: 'Humidity (%)',
                    data: hums,
                    borderColor: '#3498db', // Blue Color
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            animation: false, // Turn off animation so it doesn't "bounce" every update
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// ==========================================
// 4. INITIALIZATION
// ==========================================

// Run the update function every 2000 milliseconds (2 seconds)
setInterval(updateDashboard, 2000);

// Run it once immediately when the page loads so we don't wait 2 seconds
updateDashboard();