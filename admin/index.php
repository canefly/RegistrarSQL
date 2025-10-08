<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";

// Active Students
$res = $conn->query("SELECT COUNT(*) AS total FROM students WHERE student_status = 'Enrolled'");
$studentsCount = $res->fetch_assoc()['total'] ?? 0;

// Pending Requests
$res = $conn->query("SELECT COUNT(*) AS total FROM document_requests WHERE status = 'Pending'");
$pendingRequests = $res->fetch_assoc()['total'] ?? 0;

// Masterlists
$res = $conn->query("SELECT COUNT(*) AS total FROM masterlists");
$masterlistCount = $res->fetch_assoc()['total'] ?? 0;

// Recent Requests (limit 5)
$recentRequests = $conn->query("
  SELECT r.request_id, r.document_type, r.status, r.request_date, s.first_name, s.last_name
  FROM document_requests r
  LEFT JOIN students s ON r.student_id = s.student_id
  ORDER BY r.request_date DESC
  LIMIT 5
");

// Recent Logs (limit 3)
$recentLogs = $conn->query("
  SELECT level, message, timestamp 
  FROM system_logs 
  ORDER BY timestamp DESC 
  LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Dashboard</title>
  <link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
  <link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../components/css/StaffDashboard.css">
</head>
<body>

<?php include 'AdminSidenav.php'; ?>

<div class="container">
  <h1>Welcome, Admin</h1>
  <p>Quick overview of registrar activities.</p>

  <!-- Quick Stats -->
  <div class="stats">
    <div class="card">Enrolled Active Students: <strong><?= $studentsCount ?></strong></div>
    <div class="card">Pending Requests: <strong><?= $pendingRequests ?></strong></div>
    <div class="card">Masterlists: <strong><?= $masterlistCount ?></strong></div>
  </div>

  <!-- Recent Document Requests -->
  <div class="section">
    <h2>Recent Document Requests</h2>
    <table>
      <tr><th>Student</th><th>Document</th><th>Date</th><th>Status</th></tr>
      <?php while ($row = $recentRequests->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['first_name']." ".$row['last_name']) ?></td>
          <td><?= htmlspecialchars($row['document_type']) ?></td>
          <td><?= htmlspecialchars($row['request_date']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <!-- Recent Activity Logs -->
  <div class="section">
    <h2>Recent Activity Logs</h2>
    <ul>
      <?php while ($log = $recentLogs->fetch_assoc()): ?>
        <li>[<?= $log['level'] ?>] <?= htmlspecialchars($log['message']) ?> (<?= $log['timestamp'] ?>)</li>
      <?php endwhile; ?>
    </ul>
  </div>
</div>

</body>
</html>
