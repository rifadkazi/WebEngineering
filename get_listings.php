<?php
include 'db.php';
$result = $conn->query("SELECT * FROM market_listings ORDER BY id DESC");
$rows = [];
while($r = $result->fetch_assoc()) { $rows[] = $r; }
echo json_encode($rows);
?>