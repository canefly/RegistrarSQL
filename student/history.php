<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
requireRole("Student");

// Ensure logged in
$uid = $_SESSION['user_id'] ?? null;
if (!$uid) {
    header("Location: ../index.php");
    exit();
}

// Fetch student info
$stmt = $conn->prepare("
    SELECT student_id, first_name, last_name
    FROM students
    WHERE user_id = ?
");
$stmt->bind_param("i", $uid);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) die("Student not found.");

// Fetch archived requests (corrected table + correct string binding)
$stud_id = $student['student_id'];
$stmt2 = $conn->prepare("
    SELECT document_type, status, request_date, release_date
    FROM archived_requests
    WHERE student_id = ?
    ORDER BY request_date DESC
");
$stmt2->bind_param("s", $stud_id); // Bind as string — student_id is 'S2025-xxx'
$stmt2->execute();
$history = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Request History</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
<link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../components/css/StudentDashboard.css">
<style>
.table-wrapper { overflow-x:auto; }
.history-table th, .history-table td { padding: 10px 12px; text-align: left; }
.history-table th { background: #004aad; color: #fff; }
.history-table tr:nth-child(even) { background: #f3f3f3; }
.history-table td { font-size: 15px; }
</style>
</head>
<body>
<?php include 'StudentSidenav.php'; ?>

<div class="container">
  <h1>Request History</h1>
  <p>Below are your archived or previously completed document requests.</p>

  <div class="card">
    <div class="table-wrapper">
      <table class="history-table" role="table" aria-label="Request History">
        <thead>
          <tr>
            <th>Document</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Release Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($history)): ?>
            <?php foreach ($history as $h): ?>
              <tr>
                <td><?= htmlspecialchars($h['document_type']) ?></td>
                <td><?= htmlspecialchars($h['status']) ?></td>
                <td><?= htmlspecialchars($h['request_date']) ?></td>
                <td><?= htmlspecialchars($h['release_date'] ?: '-') ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" style="text-align:center;padding:18px;">No history found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
