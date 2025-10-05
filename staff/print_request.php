<?php
require_once __DIR__ . "/../Database/connection.php";

// Get request ID
$request_id = $_GET['id'] ?? null;
if (!$request_id) {
    die("Invalid request.");
}

// Fetch request + student info
$stmt = $conn->prepare("
    SELECT r.request_id, r.document_type, r.notes, r.status, r.request_date, r.release_date,
           s.student_id, s.first_name, s.last_name, s.program, s.year_level, s.section
    FROM document_requests r
    JOIN students s ON r.student_id = s.student_id
    WHERE r.request_id = ?
");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Request not found.");
}

// Force only approved ones to be printable
if (strtolower($data['status']) !== 'approved') {
    die("Only approved requests can be printed.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Document Request Printout</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
    .header img { height: 70px; }
    .school-name { font-size: 18px; font-weight: bold; margin-top: 5px; }
    .doc-title { text-align: center; margin: 30px 0; font-size: 20px; font-weight: bold; }
    .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .info-table th, .info-table td { text-align: left; padding: 8px; }
    .footer { margin-top: 60px; text-align: right; font-weight: bold; }
    .btn-print { margin: 20px 0; }
  </style>
</head>
<body>

<div class="header">
  <img src="../components/img/bestlink logo.png" alt="Logo">
  <div class="school-name">Bestlink College of the Philippines</div>
  <div>Registrar’s Office</div>
</div>

<div class="doc-title">Receipt Record Request</div>

<table class="info-table">
  <tr>
    <th>Student Name:</th>
    <td><?= htmlspecialchars($data['first_name']." ".$data['last_name']) ?></td>
  </tr>
  <tr>
    <th>Student ID:</th>
    <td><?= htmlspecialchars($data['student_id']) ?></td>
  </tr>
  <tr>
    <th>Program / Year / Section:</th>
    <td><?= htmlspecialchars($data['program']." / ".$data['year_level']." / ".$data['section']) ?></td>
  </tr>
  <tr>
    <th>Request Type:</th>
    <td><?= htmlspecialchars($data['document_type']) ?></td>
  </tr>
  <tr>
    <th>Notes:</th>
    <td><?= htmlspecialchars($data['notes'] ?: '-') ?></td>
  </tr>
  <tr>
    <th>Request Date:</th>
    <td><?= htmlspecialchars($data['request_date']) ?></td>
  </tr>
  <tr>
    <th>Release Date:</th>
    <td><?= htmlspecialchars($data['release_date'] ?: '-') ?></td>
  </tr>
  <tr>
    <th>Status:</th>
    <td><?= htmlspecialchars($data['status']) ?></td>
  </tr>
</table>

<div class="footer">
  ___________________________<br>
  Registrar / Authorized Signatory
</div>

<script>
  window.onload = function() {
    window.print();
  }
</script>
</body>
</html>
