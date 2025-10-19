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
    SELECT student_id, first_name, last_name, program, year_level, section, photo_path
    FROM students 
    WHERE user_id = ?
");
$stmt->bind_param("i", $uid);
$stmt->execute();

$student = null;
if (method_exists($stmt, 'get_result')) {
    $res = $stmt->get_result();
    $student = $res ? $res->fetch_assoc() : null;
}

if ($student === null) {
    $stmt->bind_result($student_id_f, $first_name_f, $last_name_f, $program_f, $year_level_f, $section_f, $photo_path_f);
    if ($stmt->fetch()) {
        $student = [
            'student_id' => $student_id_f,
            'first_name' => $first_name_f,
            'last_name'  => $last_name_f,
            'program'    => $program_f,
            'year_level' => $year_level_f,
            'section'    => $section_f,
            'photo_path' => $photo_path_f,
        ];
    }
}
$stmt->close();
if (!$student) die("Student not found in database.");

$stud_id = $student['student_id'];

// === Handle deletion ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_request']) && isset($_POST['request_id'])) {
    $request_id = (int)$_POST['request_id'];

    // Fetch the request
    $stmtDel = $conn->prepare("SELECT * FROM document_requests WHERE request_id = ?");
    $stmtDel->bind_param("i", $request_id);
    $stmtDel->execute();
    $requestData = $stmtDel->get_result()->fetch_assoc();
    $stmtDel->close();

    if ($requestData) {
        // Insert into archive table
        $stmtArch = $conn->prepare("
            INSERT INTO document_requests_archive 
            (student_id, document_type, notes, request_date, status, release_date, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmtArch->bind_param(
            "isssss",
            $requestData['student_id'],
            $requestData['document_type'],
            $requestData['notes'],
            $requestData['request_date'],
            $requestData['status'],
            $requestData['release_date']
        );
        $stmtArch->execute();
        $stmtArch->close();

        // Delete original
        $stmtDel2 = $conn->prepare("DELETE FROM document_requests WHERE request_id = ?");
        $stmtDel2->bind_param("i", $request_id);
        $stmtDel2->execute();
        $stmtDel2->close();

        echo "<script>window.onload = () => alert('Request deleted and archived successfully!');</script>";
    }
}

// Fetch student requests
$stmt2 = $conn->prepare("
    SELECT request_id, document_type, notes, status, request_date, release_date
    FROM document_requests
    WHERE student_id = ?
    ORDER BY request_date DESC
");
$stmt2->bind_param("s", $stud_id);
$stmt2->execute();
$requests = [];
if (method_exists($stmt2, 'get_result')) {
    $res2 = $stmt2->get_result();
    while ($row = $res2->fetch_assoc()) {
        $requests[] = $row;
    }
}
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Student Dashboard</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
<link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../components/css/StudentDashboard.css">
<style>
/* Simple delete button style */
.delete-btn {
    background-color: #e53e3e;
    border: none;
    color: #fff;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}
.delete-btn:hover { background-color: #c53030; }
</style>
</head>
<body>
<?php include 'StudentSideNav.php'; ?>

<div class="container">
  <h1>Welcome, <?= htmlspecialchars($student['first_name'] . " " . $student['last_name']) ?></h1>
  <p>Program: <?= htmlspecialchars($student['program']) ?> (Year <?= htmlspecialchars($student['year_level']) ?>)</p>

  <div class="card">
    <h2>My Requests</h2>

    <div class="table-wrapper">
      <table class="request-table" role="table" aria-label="My Requests">
        <thead>
          <tr>
            <th>Document</th>
            <th>Notes</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Release Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($requests)): ?>
            <?php foreach ($requests as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['document_type']) ?></td>
                <td><?= htmlspecialchars($r['notes']) ?></td>
                <td><?= htmlspecialchars($r['status']) ?></td>
                <td><?= htmlspecialchars($r['request_date']) ?></td>
                <td><?= htmlspecialchars($r['release_date'] ?: '-') ?></td>
                <td>
                  <form method="POST" onsubmit="return confirm('Are you sure you want to delete this request?');">
                    <input type="hidden" name="request_id" value="<?= $r['request_id'] ?>">
                    <button type="submit" name="delete_request" class="delete-btn">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6" style="text-align:center;padding:18px;">No requests found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
