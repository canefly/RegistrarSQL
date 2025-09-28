

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="../components/css/StaffDashboard.css">
</head>
<body>

<?php include 'StaffSidenav.php'; 
require_once __DIR__ . "/../Database/session-checker.php";?>


<div class="container">
  <h1>Welcome to Staff Dashboard</h1>
  <p>Quick overview of registrar activities.</p>

  <div class="stats">
    <div class="card">
      <h2>1,240</h2>
      <p>Total Students</p>
    </div>
    <div class="card">
      <h2>4</h2>
      <p>Pending Enrollments</p>
    </div>
    <div class="card">
      <h2>45</h2>
      <p>Document Requests</p>
    </div>
    <div class="card">
      <h2>8</h2>
      <p>Staff Users</p>
    </div>
  </div>
  

  <div class="stats">
    <div class="card">
      <h2>620</h2>
      <p>College Students</p>
    </div>
    <div class="card">
      <h2>620</h2>
      <p>Senior High Students</p>
    </div>
</div>

</body>
</html>
