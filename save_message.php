<?php
include 'db.php';

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $name = $data['name'];
    $email = $data['email'];
    $msg = $data['message'];

    // Prepare SQL statement (prevents hacking)
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $msg);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error saving message."]);
    }
    
    $stmt->close();
    $conn->close();
}
?>