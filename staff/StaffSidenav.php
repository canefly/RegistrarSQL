<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<head>
  <meta charset="UTF-8">
  <title>Sidebar Example</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Outfit', sans-serif;
      background: #f9f9f9;
      color: #333;
      display: flex;
    }

    /* Sidebar main css*/
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

    /* Collapsed sidebar */
    .sidebar.collapsed {
      width: 70px;
    }
    .sidebar.collapsed .sidebar-text {
      display: none;
    }
    .sidebar.collapsed .sidebar-header img {
      width: 40px;
      height: 40px;
    }

    /* Header */
    .sidebar-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .sidebar-header img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 3px #0056d2 solid;
    }
    .sidebar-header h3 {
      margin: 10px 0 5px;
      font-size: 16px;
    }
    .sidebar-header p {
      font-size: 13px;
      color: #666;
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

    .toggle-btn {
      position: fixed;
      top: 20px;
      left: 250px;
      background: #0056d2;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 50%;
      cursor: pointer;
      transition: left 0.3s ease, transform 0.3s ease;
      z-index: 1100;
    }
    .toggle-btn i {
      font-size: 18px;
    }
    .sidebar.collapsed + .toggle-btn {
      left: 80px;
    }
    .sidebar.collapsed + .toggle-btn i {
      transform: rotate(180deg);
    }

    /* Content area */
    .content {
      margin-left: 240px;
      padding: 20px;
      transition: margin-left 0.3s ease;
      flex: 1;
    }
    .sidebar.collapsed ~ .content {
      margin-left: 70px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <img src="../components/img/nabunturan.png" alt="Profile">
    <h3 class="sidebar-text">Justin Nabunturan</h3>
    <p class="sidebar-text">Registrar Staff</p>
  </div>

  <div class="sidebar-section">
    <h4 class="sidebar-text">MAIN</h4>
    <a href="StaffDashboard.php" class="<?= $current_page=='StaffDashboard.php' ? 'active' : '' ?>">
      <i class="fas fa-th-large"></i><span class="sidebar-text">  Dashboard</span>
    </a>
    <a href="Enrollment.php" class="<?= $current_page=='Enrollment.php' ? 'active' : '' ?>">
      <i class="fas fa-user-graduate"></i><span class="sidebar-text">  Enrollment</span>
    </a>
    <a href="StudentInfo.php" class="<?= $current_page=='StudentInfo.php' ? 'active' : '' ?>">
      <i class="fas fa-id-card"></i><span class="sidebar-text">  Student Info</span>
    </a>
    <a href="Masterlist.php" class="<?= $current_page=='Masterlist.php' ? 'active' : '' ?>">
      <i class="fas fa-list"></i><span class="sidebar-text">  Masterlists</span>
    </a>
    <a href="Request.php" class="<?= $current_page=='Request.php' ? 'active' : '' ?>">
      <i class="fas fa-file-alt"></i><span class="sidebar-text">  Request</span>
    </a>
  </div>

  <div class="sidebar-section">
    <h4 class="sidebar-text">ACCOUNT</h4>
    <a href="#">
      <i class="fas fa-cog"></i><span class="sidebar-text"> Settings</span>
    </a>
    <a href="logout.php" class="logout">
      <i class="fas fa-sign-out-alt"></i><span class="sidebar-text"> Logout</span>
    </a>
  </div>
</div>

<!-- Toggle Button -->
<button class="toggle-btn" id="toggleBtn">
  <i class="fas fa-angle-left"></i>
</button>


<script>
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggleBtn");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");
});

function handleResize() {
  if (window.innerWidth <= 720) {
    sidebar.classList.add("collapsed");
    body.classList.remove("sidebar-open");
  } else {
    sidebar.classList.remove("collapsed");
    body.classList.remove("sidebar-open");
  }
}
window.addEventListener("resize", handleResize);
handleResize(); // run on first load
</script>

</body>
</html>
