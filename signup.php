<?php
include 'db.php';
header('Content-Type: application/json');

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $user = $data['username'];
    $email = $data['email'];
    $pass = $data['password'];

    // 1. Check if username already exists
    $check = $conn->query("SELECT id FROM users WHERE username='$user'");
    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Username already taken!"]);
        exit();
    }

    // 2. Hash the password (SECURITY CRITICAL)
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // 3. Insert into DB
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Account created! You can now login."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}
$conn->close();
?>