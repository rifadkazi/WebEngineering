<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Management</title>
    <link rel="stylesheet" href="crop-management.css">
    <style>
        /* Extra styles for the History Table */
        .history-section {
            padding: 40px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #27ae60;
            color: white;
        }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="crop-management.php">Crop Management</a></li>
            <li><a href="weather-updates.php">Weather Updates</a></li>
            <li><a href="market-insights.php">Market Insights</a></li>
        </ul>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Crop Management Solutions</h1>
            <p>Optimize yields and enhance productivity with cutting-edge technology.</p>
        </div>
    </header>

    <section id="crop-budget" class="crop-budget">
        <h2>Crop Budget Calculator</h2>
        <div class="crop-budget-grid">
            <div class="crop-budget-card">
                <h3>Create New Budget</h3>
                <form id="budget-calculator">
                    <label for="budget-name" style="color: #27ae60; font-weight: bold;">Budget Name:</label>
                    <input type="text" id="budget-name" name="budget-name" placeholder="e.g. Corn Field A" required>
                    
                    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label>Acreage:</label>
                            <input type="number" id="acreage" required>
                        </div>
                        <div>
                            <label>Expected Yield:</label>
                            <input type="number" id="expected-yield" required>
                        </div>
                        <div>
                            <label>Price ($/Bushel):</label>
                            <input type="number" id="price-per-bushel" required>
                        </div>
                    </div>

                    <h4 style="margin-top:20px;">Costs (Per Acre)</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <input type="number" id="seed-cost" placeholder="Seed Cost">
                        <input type="number" id="fertilizer-cost" placeholder="Fertilizer Cost">
                        <input type="number" id="pesticide-cost" placeholder="Pesticide Cost">
                        <input type="number" id="labor-cost" placeholder="Labor Cost">
                        <input type="number" id="other-cost" placeholder="Other Costs">
                    </div>
                    
                    <button type="button" onclick="calculateAndSave()" style="margin-top: 20px;">Calculate & Save</button>
                </form>
                <div id="budget-result"></div>
            </div>
        </div>
    </section>

    <section class="history-section">
        <h2>📜 Recent Calculations</h2>
        <table>
            <thead>
                <tr>
                    <th>Budget Name</th>
                    <th>Acreage</th>
                    <th>Total Cost</th>
                    <th>Total Revenue</th>
                    <th>Profit</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="history-table-body">
                </tbody>
        </table>
    </section>

    <footer class="footer">
        <p>&copy; 2024 AgriCare. All rights reserved.</p>
    </footer>

    <script>
        // 1. Calculate and Save Function
        function calculateAndSave() {
            const budgetName = document.getElementById('budget-name').value;
            if(budgetName.trim() === "") { alert("Please enter a Budget Name!"); return; }

            // Get Values (default to 0 if empty)
            const acreage = parseFloat(document.getElementById('acreage').value) || 0;
            const seed = parseFloat(document.getElementById('seed-cost').value) || 0;
            const fert = parseFloat(document.getElementById('fertilizer-cost').value) || 0;
            const pest = parseFloat(document.getElementById('pesticide-cost').value) || 0;
            const labor = parseFloat(document.getElementById('labor-cost').value) || 0;
            const other = parseFloat(document.getElementById('other-cost').value) || 0;
            const yieldVal = parseFloat(document.getElementById('expected-yield').value) || 0;
            const price = parseFloat(document.getElementById('price-per-bushel').value) || 0;

            // Calculate
            const totalCost = (seed + fert + pest + labor + other) * acreage;
            const totalRevenue = (yieldVal * price) * acreage;
            const totalProfit = totalRevenue - totalCost;

            // Show Result
            document.getElementById('budget-result').innerHTML = `
                <h4>Results for: ${budgetName}</h4>
                <p>Profit: <b>$${totalProfit.toFixed(2)}</b></p>
                <p><i>Saving...</i></p>
            `;

            // Prepare Data
            const data = {
                budget_name: budgetName,
                acreage: acreage,
                seed_cost: seed,
                fertilizer_cost: fert,
                pesticide_cost: pest,
                labor_cost: labor,
                other_cost: other,
                expected_yield: yieldVal,
                price_per_bushel: price,
                total_cost: totalCost,
                total_revenue: totalRevenue,
                total_profit: totalProfit
            };

            // Send to PHP
            fetch('save_budget.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                document.getElementById('budget-result').innerHTML += `<p style="color:blue">✅ Saved!</p>`;
                loadHistory(); // Reload table after saving
            });
        }

        // 2. Load History Function (NEW)
        function loadHistory() {
            fetch('get_budgets.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('history-table-body');
                    tableBody.innerHTML = ""; // Clear existing rows

                    data.forEach(row => {
                        // Color code profit: Green if positive, Red if negative
                        const profitColor = row.total_profit >= 0 ? '#27ae60' : '#e74c3c';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.budget_name}</td>
                            <td>${row.acreage} acres</td>
                            <td>$${parseFloat(row.total_cost).toFixed(2)}</td>
                            <td>$${parseFloat(row.total_revenue).toFixed(2)}</td>
                            <td style="color: ${profitColor}; font-weight:bold;">$${parseFloat(row.total_profit).toFixed(2)}</td>
                            <td>${row.created_at}</td>
                        `;
                        tableBody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error loading history:', error));
        }

        // Load history when page opens
        loadHistory();
    </script>
</body>
</html>