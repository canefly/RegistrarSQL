<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";

// Ensure logged in
$uid = $_SESSION['user_id'] ?? null;
if (!$uid) {
    header("Location: ../index.php");
    exit();
}

// Fetch student info
$stmt = $conn->prepare("
  SELECT 
    s.student_id, s.first_name, s.last_name, s.birthdate, s.gender,
    s.email, s.contact_no
  FROM students s
  WHERE s.user_id = ?
");
$stmt->bind_param("i", $uid);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) die("Student not found.");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Settings</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
<link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;700&display=swap" rel="stylesheet">
<style>
/* Global layout and sidebar offset */
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}
.content, .container {
  flex: 1;
  margin-left: 240px;
  padding: 20px 40px;
  transition: margin-left 0.3s ease;
  box-sizing: border-box;
}
.sidebar.collapsed ~ .content,
.sidebar.collapsed ~ .container {
  margin-left: 70px;
}
@media (max-width: 768px) {
  .content, .container {
    margin-left: 0;
    padding: 20px;
  }
}
h1 { color: #004aad; margin-bottom: 10px; }
h2 { margin-top: 40px; color: #222; }
form label {
  font-weight: 600;
  display: block;
  margin-top: 10px;
}
form input {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
}
form input[readonly] {
  background: #f3f3f3;
  color: #555;
  cursor: not-allowed;
}
.note-box {
  margin-top: 40px;
  background: #eef3ff;
  border-left: 5px solid #004aad;
  padding: 20px;
  border-radius: 8px;
  color: #1e3a8a;
  font-size: 15px;
  line-height: 1.6;
}
</style>
</head>
<body>
<?php include 'StudentSidenav.php'; ?>

<div class="container">
  <h1>Account Settings</h1>
  <p>Review your personal information and your account details.</p>

  <!-- Readonly Info -->
  <form>
    <h2>Personal Information</h2>
    <label>First Name</label>
    <input type="text" value="<?= htmlspecialchars($student['first_name']) ?>" readonly>

    <label>Last Name</label>
    <input type="text" value="<?= htmlspecialchars($student['last_name']) ?>" readonly>

    <label>Birthdate</label>
    <input type="text" value="<?= htmlspecialchars($student['birthdate']) ?>" readonly>

    <label>Gender</label>
    <input type="text" value="<?= htmlspecialchars($student['gender']) ?>" readonly>

    <h2>Contact Information</h2>
    <label>Email</label>
    <input type="text" value="<?= htmlspecialchars($student['email']) ?>" readonly>

    <label>Contact Number</label>
    <input type="text" value="<?= htmlspecialchars($student['contact_no']) ?>" readonly>
  </form>

  <!-- Important Note -->
  <div class="note-box">
    <strong>Important Notice:</strong><br>
    If you need to change your password or have forgotten your login credentials, 
    please proceed to the <strong>Ascend Asia (AA’s) Office</strong> for assistance. <br><br>
    Kindly <strong>bring your valid school ID</strong> for verification purposes. 
    Password modifications are handled by authorized administrative personnel 
    to ensure account security and proper verification.
  </div>
</div>
</body>
</html>
