<?php
include 'db.php';

// Receive JSON data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // 1. Get the new Name field
    $name = $data['budget_name'];

    // 2. Get the rest of the numbers
    $acreage = $data['acreage'];
    $seed = $data['seed_cost'];
    $fert = $data['fertilizer_cost'];
    $pest = $data['pesticide_cost'];
    $labor = $data['labor_cost'];
    $other = $data['other_cost'];
    $yield = $data['expected_yield'];
    $price = $data['price_per_bushel'];
    $total_cost = $data['total_cost'];
    $total_rev = $data['total_revenue'];
    $total_prof = $data['total_profit'];

    // 3. Insert Name into the database
    $sql = "INSERT INTO crop_budgets 
    (budget_name, acreage, seed_cost, fertilizer_cost, pesticide_cost, labor_cost, other_cost, expected_yield, price_per_bushel, total_cost, total_revenue, total_profit) 
    VALUES 
    ('$name', '$acreage', '$seed', '$fert', '$pest', '$labor', '$other', '$yield', '$price', '$total_cost', '$total_rev', '$total_prof')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Saved: " . $name]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}
$conn->close();
?>