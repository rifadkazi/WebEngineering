<?php
include 'db.php';

// FIX: We must select 'id' in the inner query so the outer query can sort by it
$sql = "SELECT * FROM (
            SELECT id, reading_time, temperature, humidity 
            FROM sensor_data 
            ORDER BY id DESC LIMIT 10
        ) sub ORDER BY id ASC"; 

$result = $conn->query($sql);

$data = array();
if ($result) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    // If SQL fails, send an empty array instead of crashing
    $data = []; 
}

echo json_encode($data);
$conn->close();
?>