<?php
session_start();
require_once "Database/connection.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, username, password_hash, role_id, active FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['active'] == 1) {
        if ($password === $user['password_hash']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['role_id'];

            switch ($user['role_id']) {
                case 1: header("Location: admin/index.php"); exit();
                case 2: header("Location: staff/index.php"); exit();
                case 3: header("Location: student/index.php"); exit();
                default: $error = "Unknown role.";
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
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
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
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter your username" required>

      <label for="password">Password</label>
      <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <i class='bx bx-hide toggle-password' id="togglePassword"></i>
      </div>

      <div class="form-footer">
        <a href="#" class="forgot" onclick="document.getElementById('forgotPasswordModal').style.display='flex'">
          Forgot Password?
        </a>
      </div>

      <button type="submit">Login</button>
    </form>
  </div>

  <!-- Forgot Password Modal -->
  <div id="forgotPasswordModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="document.getElementById('forgotPasswordModal').style.display='none'">&times;</span>
      <h2>Forgot Password</h2>
      <p>
        If you have forgotten your password, please visit the
        <strong>Academic Affairs Office</strong> to request a password reset.
        <br><br>
        Bring a valid school ID or proof of enrollment for verification.
      </p>
      <button onclick="document.getElementById('forgotPasswordModal').style.display='none'">Got it</button>
    </div>
  </div>

  <script>
    // splash screen
    window.addEventListener("load", () => {
      setTimeout(() => {
        document.getElementById("splash").style.opacity = "0";
        setTimeout(() => {
          document.getElementById("splash").style.display = "none";
          document.getElementById("login-container").style.display = "block";
        }, 800);
      }, 2000);
    });

    // toggle password
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
      const isPassword = passwordField.type === 'password';
      passwordField.type = isPassword ? 'text' : 'password';
      togglePassword.classList.toggle('bx-hide', !isPassword);
      togglePassword.classList.toggle('bx-show', isPassword);
    });
  </script>
</body>
</html>
