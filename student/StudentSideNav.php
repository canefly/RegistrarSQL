<?php
  require_once __DIR__ . "/../Database/session-checker.php";
  require_once __DIR__ . "/../Database/connection.php";
requireRole("Student");

  $current_page = basename($_SERVER['PHP_SELF']);

  if (!isset($_SESSION['user_id'])) {
      header("Location: ../index.php");
      exit();
  }

  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("
      SELECT u.username, r.name AS role_name
      FROM users u
      JOIN roles r ON u.role_id = r.role_id
      WHERE u.user_id = ?
  ");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  $staffName = $user['username'] ?? "Unknown User";
  $staffRole = $user['role_name'] ?? "Unknown Role";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  display: flex;
  min-height: 100vh;
}

/* --- Sidebar --- */
.sidebar {
  position: fixed;
  top: 0; left: 0;
  height: 100%;
  width: 240px;
  background: #fff;
  box-shadow: 2px 0 8px rgba(0,0,0,0.08);
  padding: 20px 0;
  transition: width 0.3s ease;
  overflow-y: auto;
  z-index: 900;
}
.sidebar.collapsed {
  width: 70px;
}
.sidebar.collapsed .sidebar-text,
.sidebar.collapsed .section-title {
  display: none;
}
.sidebar.collapsed a {
  justify-content: center;
}

/* Sidebar Header */
.sidebar-header {
  text-align: center;
  margin-bottom: 25px;
}
.sidebar-header h3 {
  margin: 0;
  font-size: 16px;
  color: #0056d2;
  font-weight: 600;
}
.sidebar-header p {
  font-size: 12px;
  color: #888;
  margin-top: 3px;
}

/* Section Titles */
.section-title {
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #9ca3af;
  margin: 10px 20px;
  font-weight: 600;
}

/* Sidebar Links */
.sidebar a {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: #333;
  padding: 10px 18px;
  border-radius: 8px;
  margin: 3px 10px;
  transition: background 0.3s, color 0.3s;
  font-size: 15px;
}
.sidebar a i {
  width: 20px;
  margin-right: 12px;
  font-size: 16px;
}
.sidebar a:hover {
  background: #e8f0fe;
  color: #0056d2;
}
.sidebar a.active {
  background: #dce6ff;
  color: #003b99;
  font-weight: 600;
}
.sidebar a.logout {
  color: #c62828;
}
.sidebar a.logout:hover {
  background: #ffe6e6;
  color: #b71c1c;
}

/* --- Content --- */
.content {
  flex: 1;
  margin-left: 240px;
  padding: 100px 30px 30px;
  transition: margin-left 0.3s ease;
}
.sidebar.collapsed ~ .content {
  margin-left: 70px;
}

/* --- Burger --- */
.burger {
  display: none;
  position: fixed;
  top: 16px;
  left: 16px;
  background: transparent;
  color: #0056d2;
  border: none;
  padding: 6px 8px;
  font-size: 22px;
  cursor: pointer;
  z-index: 1001;
  transition: opacity 0.4s ease, transform 0.2s ease;
  opacity: 0; /* starts hidden until triggered */
}

.burger:hover {
  opacity: 0.8;
  transform: scale(1.1);
}

.burger i {
  text-shadow: 0 1px 2px rgba(0,0,0,0.2);  /* subtle visibility boost */
}

/* --- Dropdown --- */
.icon-dropdown {
  position: fixed;
  top: 60px; left: 16px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  padding: 8px 0;
  display: none;
  flex-direction: column;
  width: 200px;
  z-index: 999;
}
.icon-dropdown a {
  display: flex;
  align-items: center;
  padding: 10px 14px;
  text-decoration: none;
  color: #333;
  transition: background 0.2s, color 0.2s;
}
.icon-dropdown a i {
  font-size: 16px;
  margin-right: 10px;
  width: 22px;
  text-align: center;
}
.icon-dropdown a:hover {
  background: #e8f0fe;
  color: #0056d2;
}
.icon-dropdown a.logout:hover {
  background: #ffe6e6;
  color: #b71c1c;
}

/* --- Responsive --- */
@media (max-width: 720px) {
  .sidebar {
    display: none;
  }
  .burger {
    display: block;
  }
  .content {
    margin-left: 0;
    padding-top: 80px; /* space below burger */
  }
}
</style>
</head>
<body>

<!-- Burger -->
<button class="burger" id="burger"><i class="fas fa-bars"></i></button>

<!-- Mobile Dropdown -->
<div class="icon-dropdown" id="iconDropdown">
  <a href="index.php"><i class="fas fa-th-large"></i>Dashboard</a>
  <a href="Request.php"><i class="fas fa-file-alt"></i>Request</a>
  <a href="Forms.php"><i class="fa-solid fa-file-lines"></i>Forms</a>
  <a href="history.php"><i class="fa-solid fa-clock-rotate-left"></i>History</a>
  <a href="StudentSettings.php"><i class="fa-solid fa-gear"></i>Settings</a>
  <a href="../Database/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h3 class="sidebar-text"><?= htmlspecialchars($staffName) ?></h3>
    <p class="sidebar-text"><?= htmlspecialchars($staffRole) ?></p>
  </div>

  <div class="section-title">Main</div>
  <a href="index.php" class="<?= $current_page=='index.php' ? 'active' : '' ?>"><i class="fas fa-th-large"></i><span class="sidebar-text">Dashboard</span></a>
  <a href="Request.php" class="<?= $current_page=='Request.php' ? 'active' : '' ?>"><i class="fas fa-file-alt"></i><span class="sidebar-text">Request</span></a>
  <a href="Forms.php" class="<?= $current_page=='Forms.php' ? 'active' : '' ?>"><i class="fa-solid fa-file-lines"></i><span class="sidebar-text">Forms</span></a>
  <a href="history.php" class="<?= $current_page=='history.php' ? 'active' : '' ?>"><i class="fa-solid fa-clock-rotate-left"></i><span class="sidebar-text">History</span></a>

  <div class="section-title">Account</div>
  <a href="StudentSettings.php" class="<?= $current_page=='StudentSettings.php' ? 'active' : '' ?>"><i class="fa-solid fa-gear"></i><span class="sidebar-text">Account Overview
  </span></a>
  <a href="../Database/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i><span class="sidebar-text">Logout</span></a>
</div>


<script>
const sidebar = document.getElementById("sidebar");
const burger = document.getElementById("burger");
const iconDropdown = document.getElementById("iconDropdown");
let collapseTimeout;

// Sidebar auto-collapse
sidebar.addEventListener("mouseenter", () => {
  clearTimeout(collapseTimeout);
  sidebar.classList.remove("collapsed");
});
sidebar.addEventListener("mouseleave", () => {
  collapseTimeout = setTimeout(() => sidebar.classList.add("collapsed"), 800);
});

// Burger toggle
burger.addEventListener("click", () => {
  iconDropdown.style.display = iconDropdown.style.display === "flex" ? "none" : "flex";
});

// Close dropdown when clicking outside
window.addEventListener("click", e => {
  if (!burger.contains(e.target) && !iconDropdown.contains(e.target)) {
    iconDropdown.style.display = "none";
  }
});

// Optional adaptive color logic
const burgerIcon = burger.querySelector('i');
window.addEventListener('scroll', () => {
  if (window.scrollY > 40) {
    burgerIcon.style.color = '#fff';
  } else {
    burgerIcon.style.color = '#0056d2';
  }
});

// === Auto fade burger button ===
let burgerTimeout;
const fadeDelay = 3000; // ms

function showBurger() {
  burger.style.opacity = "1";
  burger.style.pointerEvents = "auto";
  clearTimeout(burgerTimeout);
  burgerTimeout = setTimeout(() => {
    burger.style.opacity = "0";
    burger.style.pointerEvents = "none";
  }, fadeDelay);
}

// Listen for movement, scroll, or touch
['mousemove', 'scroll', 'touchstart'].forEach(evt => {
  window.addEventListener(evt, showBurger);
});

// Initial trigger on load
showBurger();

</script>

</body>
</html>
