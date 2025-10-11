<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/functions.php"; // ✅ for addSystemLog()
requireRole("Employee");

// 🔹 Approve request → set status + release date (today + 7 days)
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $release_date = date('Y-m-d', strtotime('+7 days'));

    // 🔍 get request + student info for logging
    $info = $conn->prepare("
        SELECT r.document_type, s.student_id, s.first_name, s.last_name
        FROM document_requests r
        LEFT JOIN students s ON r.student_id = s.student_id
        WHERE r.request_id = ?
    ");
    $info->bind_param("i", $id);
    $info->execute();
    $data = $info->get_result()->fetch_assoc();

    $stmt = $conn->prepare("UPDATE document_requests SET status = 'Approved', release_date = ? WHERE request_id = ?");
    $stmt->bind_param("si", $release_date, $id);
    $stmt->execute();

    // ✅ Add system log
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

    echo "<script>alert('Request approved! Release date set.'); window.location='Request.php';</script>";
    exit;
}

// 🔹 Decline request → set status + clear release date
if (isset($_GET['decline'])) {
    $id = intval($_GET['decline']);

    // 🔍 get request + student info for logging
    $info = $conn->prepare("
        SELECT r.document_type, s.student_id, s.first_name, s.last_name
        FROM document_requests r
        LEFT JOIN students s ON r.student_id = s.student_id
        WHERE r.request_id = ?
    ");
    $info->bind_param("i", $id);
    $info->execute();
    $data = $info->get_result()->fetch_assoc();

    $stmt = $conn->prepare("UPDATE document_requests SET status = 'Declined', release_date = NULL WHERE request_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // ✅ Add system log
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

// 🔹 Fetch requests joined with student info
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
