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

// Handle password update (plain text version)
if (isset($_POST['update_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    if ($new !== $confirm) {
        $error = "New passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($stored_pass);
        $stmt->fetch();
        $stmt->close();

        if ($stored_pass !== $current) {
            $error = "Incorrect current password.";
        } else {
            $update = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
            $update->bind_param("si", $new, $user_id);
            $update->execute();
            $update->close();
            $success = "Password updated successfully!";
        }
    }
}

// Fetch student + guardian info
$stmt = $conn->prepare("
  SELECT 
    s.student_id, s.first_name, s.last_name, s.birthdate, s.gender,
    s.email, s.contact_no,
    g.name AS guardian_name, g.relation AS guardian_relation, 
    g.contact_no AS guardian_contact, g.address AS guardian_address
  FROM students s
  LEFT JOIN guardians g ON s.student_id = g.student_id
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
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;700&display=swap" rel="stylesheet">
<style>
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}

.container {
  flex: 1;
  margin-left: 240px;
  padding: 40px 60px;
  transition: margin-left 0.3s ease;
  box-sizing: border-box;
}
.sidebar.collapsed ~ .container { margin-left: 70px; }

@media (max-width: 768px) {
  .container { margin-left: 0; padding: 20px; }
}

h1 {
  color: #004aad;
  font-weight: 700;
  margin-bottom: 15px;
}
p {
  font-size: 16px;
  color: #444;
  margin-bottom: 25px;
}

form {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  padding: 25px 30px;
  margin-bottom: 40px;
  width: 100%;
  box-sizing: border-box;
}
form h2 {
  color: #222;
  margin-top: 0;
  border-left: 4px solid #004aad;
  padding-left: 10px;
  font-size: 20px;
}
label {
  font-weight: 600;
  display: block;
  margin-top: 15px;
  color: #333;
}
input, textarea {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
  resize: none;
  box-sizing: border-box;
}
input[readonly], textarea[readonly] {
  background: #f3f3f3;
  color: #555;
  cursor: not-allowed;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px 30px;
}

textarea {
  min-height: 80px;
  max-width: 100%;
  overflow-wrap: break-word;
  word-break: break-word;
}

@media (max-width: 480px) {
  form { padding: 20px; }
  h1 { font-size: 22px; }
  form h2 { font-size: 18px; }
  input, textarea { font-size: 14px; }
  .info-grid { grid-template-columns: 1fr; gap: 12px; }
  textarea { min-height: 90px; }
}

/* Password form styling */
form button {
  background: #004aad;
  color: #fff;
  border: none;
  padding: 10px;
  border-radius: 8px;
  font-size: 15px;
  cursor: pointer;
  transition: background 0.3s ease;
  margin-top: 15px;
}
form button:hover { background: #00348a; }

/* Fade-out messages */
.success, .error {
  font-weight: 600;
  margin-top: 10px;
  padding: 10px;
  border-radius: 6px;
  animation: fadeIn 0.3s ease;
  opacity: 1;
  transition: opacity 0.5s ease;
}
.success {
  color: #2e7d32;
  background: #e8f5e9;
}
.error {
  color: #c62828;
  background: #ffebee;
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
.fade-out {
  opacity: 0;
}
</style>
</head>

<body>
<?php include 'StudentSideNav.php'; ?>

<div class="container">
  <h1>Account Overview</h1>
  <p>Review your account settings, credentials, and profile information in one place.</p>

  <form>
    <h2>Personal Information</h2>
    <div class="info-grid">
      <div><label>First Name</label>
        <input type="text" value="<?= htmlspecialchars($student['first_name']) ?>" readonly></div>
      <div><label>Last Name</label>
        <input type="text" value="<?= htmlspecialchars($student['last_name']) ?>" readonly></div>
      <div><label>Birthdate</label>
        <input type="text" value="<?= htmlspecialchars($student['birthdate']) ?>" readonly></div>
      <div><label>Gender</label>
        <input type="text" value="<?= htmlspecialchars($student['gender']) ?>" readonly></div>
    </div>
  </form>

  <form>
    <h2>Contact Information</h2>
    <div class="info-grid">
      <div><label>Email</label>
        <input type="text" value="<?= htmlspecialchars($student['email']) ?>" readonly></div>
      <div><label>Contact Number</label>
        <input type="text" value="<?= htmlspecialchars($student['contact_no']) ?>" readonly></div>
    </div>
  </form>

  <form>
    <h2>Guardian Information</h2>
    <div class="info-grid">
      <div><label>Guardian's Name</label>
        <input type="text" value="<?= htmlspecialchars($student['guardian_name'] ?? 'N/A') ?>" readonly></div>
      <div><label>Relationship</label>
        <input type="text" value="<?= htmlspecialchars($student['guardian_relation'] ?? 'N/A') ?>" readonly></div>
      <div><label>Guardian Contact Number</label>
        <input type="text" value="<?= htmlspecialchars($student['guardian_contact'] ?? 'N/A') ?>" readonly></div>
      <div><label>Address</label>
        <textarea rows="2" readonly><?= htmlspecialchars($student['guardian_address'] ?? 'N/A') ?></textarea></div>
    </div>
  </form>

  <!-- Change Password -->
  <form method="POST" action="">
    <h2>Change Password</h2>
    <label>Current Password</label>
    <input type="password" name="current_password" required>

    <label>New Password</label>
    <input type="password" name="new_password" minlength="4" required>

    <label>Confirm New Password</label>
    <input type="password" name="confirm_password" minlength="4" required>

    <button type="submit" name="update_password">Update Password</button>

    <?php if (isset($success)): ?>
      <p class="success" id="message"><?= htmlspecialchars($success) ?></p>
    <?php elseif (isset($error)): ?>
      <p class="error" id="message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </form>

</div>

<!-- JS fade-out for messages -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
const msg = document.getElementById('message');
if (msg) {
  setTimeout(() => {
    msg.classList.add('fade-out');
    setTimeout(() => msg.remove(), 600); // fully remove from DOM after fade
  }, 3000); // 3 seconds before fade starts
}

<!-- JS for collapsible -->
const noticeHeader = document.getElementById("noticeHeader");
const noticeBox = document.getElementById("noticeBox");

noticeHeader.addEventListener("click", () => {
  noticeBox.classList.toggle("active");
});
</script>
</body>
</html>
