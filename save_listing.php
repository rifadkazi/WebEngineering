<?php
include 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
if ($data) {
    $conn->query("INSERT INTO market_listings (farmer_name, crop_name, quantity, price, contact) 
                  VALUES ('{$data['farmer_name']}', '{$data['crop_name']}', '{$data['quantity']}', '{$data['price']}', '{$data['contact']}')");
    echo json_encode(["message" => "Listing Posted!"]);
}
?>