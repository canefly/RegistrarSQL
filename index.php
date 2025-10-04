<?php
session_start();
require_once "Database/connection.php"; // adjust if path differs

$error = "";

// Handle login submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query user
    $stmt = $conn->prepare("SELECT user_iawdadwadwd, username, password_hash, role_id, active FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['active'] == 1) {
        // ⚠ Replace this with password_verify if you switch to hashed passwords
        if ($password === $user['password_hash']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['role_id'];

            // Redirect based on role
            switch ($user['role_id']) {
                case 1: // Admin
                    header("Location: admin/index.php");
                    exit();
                case 2: // Employee
                    header("Location: staff/index.php");
                    exit();
                case 3: // Student
                    header("Location: student/index.php");
                    exit();
                default:
                    $error = "Unknown role.";
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found or inactive.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Login</title>
  <link rel="stylesheet" href="components/css/LoginPage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
  <!-- splash screen -->
  <div id="splash">
    <img src="components/img/bestlink logo.png" alt="School Logo">
    <div class="loader"></div>
  </div>

  <!-- login form -->
  <div id="login-container" style="display:none;">
    <h2>Registrar</h2>

    <?php if ($error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter your username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>

      <a href="#" class="forgot">Forgot Password?</a>
      <button type="submit">Login</button>
    </form>
  </div>

  <script>
    // splash screen animation
    window.addEventListener("load", () => {
      setTimeout(() => {
        document.getElementById("splash").style.opacity = "0";
        setTimeout(() => {
          document.getElementById("splash").style.display = "none";
          document.getElementById("login-container").style.display = "block";
        }, 800);
      }, 2000);
    });
  </script>
</body>
</html>
