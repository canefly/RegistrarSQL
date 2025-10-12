<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
requireRole("Employee");
// 🕛 AUTO-ARCHIVE after 11:59 PM if approved or declined
$today = date('Y-m-d');

// Find all requests before today that were already approved or declined
$archive_sql = "
    SELECT * FROM document_requests
    WHERE status IN ('Approved','Declined')
    AND DATE(request_date) < ?
";
$stmt = $conn->prepare($archive_sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Insert into archive table
    $ins = $conn->prepare("
        INSERT INTO archived_requests 
        (request_id, student_id, document_type, request_date, status, release_date)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $ins->bind_param(
        "isssss",
        $row['request_id'],
        $row['student_id'],
        $row['document_type'],
        $row['request_date'],
        $row['status'],
        $row['release_date']
    );
    $ins->execute();

    // Delete from document_requests table after archiving
    $del = $conn->prepare("DELETE FROM document_requests WHERE request_id = ?");
    $del->bind_param("i", $row['request_id']);
    $del->execute();
}

// ✅ APPROVE (add 7 days, skip Sunday)
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $release_date = new DateTime();
    $release_date->modify('+7 days');

    // If the 7th day lands on a Sunday (0 = Sunday)
    if ($release_date->format('w') == 0) {
        $release_date->modify('+1 day'); // move to Monday
    }

    $final_date = $release_date->format('Y-m-d');

    $stmt = $conn->prepare("UPDATE document_requests SET status = 'Approved', release_date = ? WHERE request_id = ?");
    $stmt->bind_param("si", $final_date, $id);
    $stmt->execute();

      if ($data) {
        $full_name = "{$data['first_name']} {$data['last_name']}";
        addSystemLog(
            $conn,
            'INFO',
            "Approved document request '{$data['document_type']}' for {$full_name} (ID: {$data['student_id']})",
            'staff/Request.php',
            $_SESSION['user_id']
        );
    }

    echo "<script>alert('Request approved! Release date set (Sunday skipped).'); window.location='Request.php';</script>";
    exit;
}

// ❌ DECLINE (clear release date)
if (isset($_GET['decline'])) {
    $id = intval($_GET['decline']);
    $stmt = $conn->prepare("UPDATE document_requests SET status = 'Declined', release_date = NULL WHERE request_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

     if ($data) {
        $full_name = "{$data['first_name']} {$data['last_name']}";
        addSystemLog(
            $conn,
            'INFO',
            "Declined document request '{$data['document_type']}' for {$full_name} (ID: {$data['student_id']})",
            'staff/Request.php',
            $_SESSION['user_id']
        );
    }

    echo "<script>alert('Request declined!'); window.location='Request.php';</script>";
    exit;
}

// 📋 FETCH requests
$sql = "SELECT r.request_id, r.document_type, r.request_date, r.status, r.release_date,
               s.first_name, s.last_name
        FROM document_requests r
        LEFT JOIN students s ON r.student_id = s.student_id
        ORDER BY r.request_date DESC";
$result = $conn->query($sql);
$requests = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
  <link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Requests</title>
  <link rel="stylesheet" href="../components/css/StaffRequest.css">
  
</head>
<body>

<?php include 'StaffSidenav.php'; ?>

<div class="container">
  <h1>  Student Requests</h1>
  <p>Below is the list of student requests awaiting review.</p>

  <table class="requests-table">
    <thead>
      <tr>
        <th>Request ID</th>
        <th>Student Name</th>
        <th>Document Type</th>
        <th>Request Date</th>
        <th>Status</th>
        <th>Release Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($requests): ?>
        <?php foreach ($requests as $req): ?>
        <tr>
          <td><?= $req['request_id'] ?></td>
          <td><?= htmlspecialchars($req['first_name'] . " " . $req['last_name']) ?></td>
          <td><?= htmlspecialchars($req['document_type']) ?></td>
          <td><?= $req['request_date'] ?></td>
          <td><span class="status <?= $req['status'] ?>"><?= $req['status'] ?></span></td>
          <td><?= $req['release_date'] ? $req['release_date'] : "-" ?></td>
          <td>
            <?php if ($req['status'] === "Pending"): ?>
              <a href="?approve=<?= $req['request_id'] ?>"><button class="approve">Approve</button></a>
              <a href="?decline=<?= $req['request_id'] ?>"><button class="decline">Decline</button></a>
            
            <?php elseif ($req['status'] === "Approved"): ?>
              <a href="print_request.php?id=<?= $req['request_id'] ?>" target="_blank">
                <button class="print">🖨 Print</button>
              </a>
            
            <?php else: ?>
              <button disabled><?= $req['status'] ?></button>
            <?php endif; ?>
          </td>

        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7">No requests found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
