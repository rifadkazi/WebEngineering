<?php
include 'db.php';

// Select all budgets, newest first
$sql = "SELECT * FROM crop_budgets ORDER BY id DESC";
$result = $conn->query($sql);

$budgets = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $budgets[] = $row;
    }
}

// Return data as JSON
echo json_encode($budgets);
$conn->close();
?>