<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";


// Fetch student details
$stmt = $conn->prepare("SELECT student_id, first_name, last_name, program, year_level, section, photo_path 
                        FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

// Fetch student requests
$stmt = $conn->prepare("SELECT document_type, request_date, status, release_date
                        FROM document_requests 
                        WHERE student_id = ?
                        ORDER BY request_date DESC LIMIT 5");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../components/css/StaffDashboard.css">
</head>
<body>
<?php include 'StudentSidenav.php'; ?>
<div class="container">
  <?php if ($student): ?>
    <h1>🎓 Welcome, <?= htmlspecialchars($student['first_name'] . " " . $student['last_name']) ?></h1>
    <p>Here’s an overview of your information and requests.</p>
  <?php else: ?>
    <h1>⚠ Student not found</h1>
    <p>Please contact the registrar’s office.</p>
  <?php endif; ?>

  <div class="card">
    <h3>📑 Recent Requests</h3>
    <table>
      <thead>
        <tr>
          <th>Document</th>
          <th>Date</th>
          <th>Status</th>
          <th>Release Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($requests): ?>
          <?php foreach ($requests as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['document_type']) ?></td>
              <td><?= $r['request_date'] ?></td>
              <td><?= $r['status'] ?></td>
              <td><?= $r['release_date'] ? $r['release_date'] : "-" ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">No requests yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
