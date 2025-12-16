<?php
session_start(); // Start session to allow auto-login
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Check if username or email already exists
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Username or Email already taken!');
                window.location.href = 'create-account.html';
              </script>";
        exit;
    }

    // 2. Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 3. Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        // --- AUTO LOGIN SECTION ---
        // Get the ID of the user we just created
        $new_user_id = $conn->insert_id;

        // Set session variables (Log them in immediately)
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;

        // Redirect to the Dashboard (index.php)
        header("Location: index.php");
        exit; 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>