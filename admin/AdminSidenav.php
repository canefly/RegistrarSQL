<?php
  require_once __DIR__ . "/../Database/session-checker.php";
  require_once __DIR__ . "/../Database/connection.php";

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
  <title>File Storage</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
  <link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Outfit', sans-serif;
      background: #f9f9f9;
      color: #333;
      display: flex;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      height: 100%;
      width: 240px;
      background: #fff;
      color: #333;
      box-shadow: 2px 0 8px rgba(0,0,0,0.1);
      padding: 20px 10px;
      transition: width 0.3s ease;
      overflow-y: auto;
      z-index: 1000;
    }
    .sidebar.collapsed {
      width: 70px;
    }
    .sidebar.collapsed .sidebar-text {
      display: none;
    }

    /* Header */
    .sidebar-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .sidebar-header h3 {
      margin: 0;
      font-size: 16px;
      font-weight: 600;
      color: #0056d2;
    }
    .sidebar-header p {
      font-size: 13px;
      color: #666;
      margin: 4px 0 0;
    }

    .sidebar-section {
      margin-bottom: 20px;
    }
    .sidebar-section h4 {
      margin: 10px 15px;
      font-size: 12px;
      text-transform: uppercase;
      color: #888;
      letter-spacing: 1px;
    }

    /* Links */
    .sidebar a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #333;
      padding: 10px 15px;
      border-radius: 8px;
      margin: 4px 0;
      transition: background 0.3s, color 0.3s;
      font-size: 15px;
    }
    .sidebar a i {
      font-size: 16px;
      width: 20px;
      text-align: center;
    }
    .sidebar a:hover {
      background: #e6f0ff;
      color: #0056d2;
    }
    .sidebar a.active {
      background: #d6e4ff;
      color: #003b99;
      font-weight: bold;
    }

    .sidebar a.logout {
      color: #c62828;
    }
    .sidebar a.logout:hover {
      background: #ffe6e6;
      color: #b71c1c;
    }

    /* Content area */
    .content {
      margin-left: 70px; /* match collapsed by default */
      padding: 20px;
      transition: margin-left 0.3s ease;
      flex: 1;
    }
    .sidebar:not(.collapsed) ~ .content {
      margin-left: 240px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar collapsed" id="sidebar">
  <div class="sidebar-header">
    <h3 class="sidebar-text"><?= htmlspecialchars($staffName) ?></h3>
    <p class="sidebar-text"><?= htmlspecialchars($staffRole) ?></p>
  </div>

  <div class="sidebar-section">
    <h4 class="sidebar-text">MAIN</h4>
    <a href="index.php" class="<?= $current_page=='index.php' ? 'active' : '' ?>">
      <i class="fas fa-th-large"></i><span class="sidebar-text"> Dashboard</span>
    </a>
    <a href="StudentInfo.php" class="<?= $current_page=='StudentInfo.php' ? 'active' : '' ?>">
      <i class="fas fa-id-card"></i><span class="sidebar-text"> Students</span>
    </a>
    <a href="Masterlist.php" class="<?= $current_page=='Masterlist.php' ? 'active' : '' ?>">
      <i class="fas fa-list"></i><span class="sidebar-text"> Masterlists</span>
    </a>
    <a href="FileStorage.php" class="<?= $current_page=='FileStorage.php' ? 'active' : '' ?>">
      <i class="fas fa-folder-open"></i><span class="sidebar-text"> File Storage</span>
    </a>
    <a href="Request.php" class="<?= $current_page=='Request.php' ? 'active' : '' ?>">
      <i class="fas fa-file-alt"></i><span class="sidebar-text"> Request</span>
    </a>
     <a href="upload_forms.php" class="<?= $current_page=='upload_forms.php' ? 'active' : '' ?>">
      <i class="fas fa-upload"></i><span class="sidebar-text"> Upload Forms</span>
    </a>
    <a href="ActivityLogs.php" class="<?= $current_page=='ActivityLogs.php' ? 'active' : '' ?>">
      <i class="fas fa-history"></i><span class="sidebar-text"> Recent Activity Logs</span>
    </a>
  </div>

  <div class="sidebar-section">
    <h4 class="sidebar-text">ACCOUNT</h4>
    <a href="Accounts.php" class="<?= $current_page=='Accounts.php' ? 'active' : '' ?>">
      <i class="fas fa-users"></i><span class="sidebar-text"> Accounts</span>
    </a>
    <a href="../Database/logout.php" class="logout">
      <i class="fas fa-sign-out-alt"></i><span class="sidebar-text"> Logout</span>
    </a>
  </div>
</div>



<script>
const sidebar = document.getElementById("sidebar");
let collapseTimeout;

// Expand on hover
sidebar.addEventListener("mouseenter", () => {
  clearTimeout(collapseTimeout);
  sidebar.classList.remove("collapsed");
});

// Collapse with delay on mouse leave
sidebar.addEventListener("mouseleave", () => {
  collapseTimeout = setTimeout(() => {
    sidebar.classList.add("collapsed");
  }, 1000); // 0.5s delay
});

// Force collapsed on small screens
function handleResize() {
  if (window.innerWidth <= 720) {
    sidebar.classList.add("collapsed");
  }
}
window.addEventListener("resize", handleResize);
handleResize();
</script>

</body>
</html>
