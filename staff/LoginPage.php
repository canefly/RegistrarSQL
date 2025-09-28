

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Login</title>
  <link rel="stylesheet" href="../components/css/LoginPage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
  <!-- splash screen -->
  <div id="splash">
    <img src="../components/img/bestlink logo.png" alt="School Logo">
    <div class="loader"></div>
  </div>

  <!-- login form -->
  <div id="login-container">
    <h2>Registrar</h2>

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

