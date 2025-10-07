<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";

// Ensure logged in
$uid = $_SESSION['user_id'] ?? null;
if (!$uid) {
    header("Location: ../index.php");
    exit();
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
/* ---------------- Global Layout ---------------- */
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}

/* Sidebar offset */
.container {
  flex: 1;
  margin-left: 240px;
  padding: 40px 60px;
  transition: margin-left 0.3s ease;
  box-sizing: border-box;
}
.sidebar.collapsed ~ .container { margin-left: 70px; }

@media (max-width: 768px) {
  .container {
    margin-left: 0;
    padding: 20px;
  }
}

/* ---------------- Headings ---------------- */
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

/* ---------------- Collapsible Notice ---------------- */
.notice-container {
  margin-bottom: 30px;
  border-left: 5px solid #004aad;
  border-radius: 10px;
  background: #eef3ff;
  overflow: hidden;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  position: relative;
}
.notice-header {
  padding: 15px 20px;
  cursor: pointer;
  font-weight: 700;
  color: #004aad;
  background: #e7edff;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.notice-header i {
  transition: transform 0.3s ease;
}
.notice-content {
  max-height: 70px;
  overflow: hidden;
  padding: 0 20px 20px 20px;
  color: #1e3a8a;
  font-size: 15px;
  line-height: 1.6;
  position: relative;
  transition: max-height 0.4s ease;
}

/* Fading overlay when collapsed */
.notice-content::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 50px;
  background: linear-gradient(to bottom, rgba(238,243,255,0), rgba(238,243,255,1));
  pointer-events: none;
  transition: opacity 0.4s ease;
}

/* Expanded state */
.notice-container.active .notice-content {
  max-height: 300px;
}
.notice-container.active .notice-content::after {
  opacity: 0;
}
.notice-container.active .notice-header i {
  transform: rotate(180deg);
}

/* ---------------- Form Section ---------------- */
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

/* -------------- Responsive grid layout -------------- */
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

/* ---------------- Responsive Touch ---------------- */
@media (max-width: 480px) {
  form {
    padding: 20px;
  }
  h1 { font-size: 22px; }
  form h2 { font-size: 18px; }
  input, textarea { font-size: 14px; }
  .info-grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  textarea {
    min-height: 90px;
  }
}
</style>
</head>

<body>
<?php include 'StudentSidenav.php'; ?>

<div class="container">
  <h1>Account Overview</h1>

  <!-- Collapsible Notice -->
  <div class="notice-container" id="noticeBox">
    <div class="notice-header" id="noticeHeader">
      <span> Important Notice</span>
      <i class="fa-solid fa-chevron-down"></i>
    </div>
    <div class="notice-content">
      If you need to change your password or have forgotten your login credentials, 
      please proceed to the <strong>Ascend Asia (AA’s) Office</strong> for assistance.<br><br>
      Kindly <strong>bring your valid school ID</strong> for verification purposes. 
      Password modifications are handled by authorized administrative personnel 
      to ensure account security and proper verification.
    </div>
  </div>

  <p>Review your account settings, credentials, and profile information in one place.</p>

  <!-- Personal Info -->
  <form>
    <h2>Personal Information</h2>
    <div class="info-grid">
      <div>
        <label>First Name</label>
        <input type="text" value="<?= htmlspecialchars($student['first_name']) ?>" readonly>
      </div>
      <div>
        <label>Last Name</label>
        <input type="text" value="<?= htmlspecialchars($student['last_name']) ?>" readonly>
      </div>
      <div>
        <label>Birthdate</label>
        <input type="text" value="<?= htmlspecialchars($student['birthdate']) ?>" readonly>
      </div>
      <div>
        <label>Gender</label>
        <input type="text" value="<?= htmlspecialchars($student['gender']) ?>" readonly>
      </div>
    </div>
  </form>

  <!-- Contact Info -->
  <form>
    <h2>Contact Information</h2>
    <div class="info-grid">
      <div>
        <label>Email</label>
        <input type="text" value="<?= htmlspecialchars($student['email']) ?>" readonly>
      </div>
      <div>
        <label>Contact Number</label>
        <input type="text" value="<?= htmlspecialchars($student['contact_no']) ?>" readonly>
      </div>
    </div>
  </form>

  <!-- Guardian Info -->
  <form>
    <h2>Guardian Information</h2>
    <div class="info-grid">
      <div>
        <label>Guardian's Name</label>
        <input type="text" value="<?= htmlspecialchars($student['guardian_name'] ?? 'N/A') ?>" readonly>
      </div>
      <div>
        <label>Relationship</label>
        <input type="text" value="<?= htmlspecialchars($student['guardian_relation'] ?? 'N/A') ?>" readonly>
      </div>
      <div>
        <label>Guardian Contact Number</label>
        <input type="text" value="<?= htmlspecialchars($student['guardian_contact'] ?? 'N/A') ?>" readonly>
      </div>
      <div>
        <label>Address</label>
        <textarea rows="2" readonly><?= htmlspecialchars($student['guardian_address'] ?? 'N/A') ?></textarea>
      </div>
    </div>
  </form>
</div>

<!-- JS for collapsible -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
const noticeHeader = document.getElementById("noticeHeader");
const noticeBox = document.getElementById("noticeBox");

noticeHeader.addEventListener("click", () => {
  noticeBox.classList.toggle("active");
});
</script>
</body>
</html>
