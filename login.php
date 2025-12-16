<?php
session_start();
include 'db.php'; // Ensure you have your database connection here

// 1. IF USER SUBMITS THE FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Secure SQL selection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify Password (assuming you use password_hash, if plain text remove password_verify)
        // If your database has plain text passwords, use: if ($password === $user['password']) {
        if (password_verify($password, $user['password'])) {
            
            // Login Success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;

            header("Location: index.php"); // Redirect to Dashboard
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgriCare</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Specific styles to center the login box on a blank page */
        body {
            background-image: url('hero.jpg'); /* Uses your hero image as background */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            width: 350px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-container button:hover {
            background-color: #2ecc71;
        }
        .error-msg {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="logos.avif" alt="AgriCare Logo" style="width: 80px; margin-bottom: 10px;">
        <h2>Welcome Back</h2>
        
        <?php if(isset($error)) { echo "<p class='error-msg'>$error</p>"; } ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p style="margin-top: 15px;">
            Don't have an account? <br>
            <a href="create-account.html" style="color: #27ae60; font-weight: bold;">Create Account</a>
        </p>
    </div>

</body>
</html>