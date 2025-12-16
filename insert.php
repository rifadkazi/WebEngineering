<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $temp = $_POST['temperature'];
    $hum = $_POST['humidity'];
    $soil = $_POST['soil_moisture'];
    $sql = "INSERT INTO sensor_data (temperature, humidity, soil_moisture) VALUES ('$temp', '$hum', '$soil')";
    $conn->query($sql);
}
?>