<?php
include 'db.php';
$result = $conn->query("SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1");
echo json_encode($result->fetch_assoc());
?>