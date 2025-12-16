<?php
include 'db.php';

// disable foreign key checks to prevent errors
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Clear all 3 main tables
$conn->query("TRUNCATE TABLE sensor_data");
$conn->query("TRUNCATE TABLE crop_budgets");
$conn->query("TRUNCATE TABLE market_listings");

$conn->query("SET FOREIGN_KEY_CHECKS = 1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Reset</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding-top: 50px; background-color: #f4f4f4; }
        .box { background: white; padding: 40px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h1 { color: #e74c3c; }
        a { text-decoration: none; color: white; background: #27ae60; padding: 10px 20px; border-radius: 5px; }
        a:hover { background: #2ecc71; }
    </style>
</head>
<body>
    <div class="box">
        <h1>✅ System Reset Successful!</h1>
        <p>All database records have been wiped clean.</p>
        <br>
        <a href="index.php">Return to Dashboard</a>
    </div>
</body>
</html>