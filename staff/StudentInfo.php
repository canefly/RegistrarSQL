<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";

// ✅ Handle student update (when staff saves changes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $birthdate  = $_POST['birthdate'];
    $program    = $_POST['program'];
    $year_level = $_POST['year_level'];
    $status     = $_POST['student_status'];

    $guardian_name    = $_POST['guardian_name'];
    $guardian_contact = $_POST['guardian_contact'];
    $guardian_address = $_POST['guardian_address'];

    // Update students table
    $stmt = $conn->prepare("UPDATE students 
        SET first_name=?, last_name=?, birthdate=?, program=?, year_level=?, student_status=? 
        WHERE student_id=?");
    $stmt->bind_param("ssssiss", $first_name, $last_name, $birthdate, $program, $year_level, $status, $student_id);
    $stmt->execute();

    // Update guardians table (if exists, else insert)
    $res = $conn->prepare("SELECT guardian_id FROM guardians WHERE student_id=?");
    $res->bind_param("s", $student_id);
    $res->execute();
    $result = $res->get_result();
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE guardians 
            SET name=?, contact_no=?, address=? 
            WHERE student_id=?");
        $stmt->bind_param("ssss", $guardian_name, $guardian_contact, $guardian_address, $student_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO guardians (student_id, name, contact_no, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_id, $guardian_name, $guardian_contact, $guardian_address);
        $stmt->execute();
    }

    echo "<script>alert('Student record updated successfully!');</script>";
}

// ✅ Fetch students
$res = $conn->query("
  SELECT s.student_id, s.first_name, s.last_name, s.program, s.year_level, s.student_status,
         g.name AS guardian_name, g.contact_no AS guardian_contact, g.address AS guardian_address,
         s.birthdate, s.gender, s.photo_path
  FROM students s
  LEFT JOIN guardians g ON s.student_id = g.student_id
  ORDER BY s.last_name ASC
");
$students = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Records</title>
  <link rel="stylesheet" href="../components/css/StudentInfo.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'StaffSidenav.php'; ?>

<div class="container">
  <h1>Student Records</h1>

  <!-- 🔎 Search -->
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Search student...">
  </div>

  <!-- 📄 Student Table -->
  <table id="studentsTable">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Program</th>
        <th>Year Level</th>
        <th>Student ID</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $s): ?>
        <tr data-student='<?= json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
          <td><?= htmlspecialchars($s['last_name'] . ", " . $s['first_name']) ?></td>
          <td><?= htmlspecialchars($s['program']) ?></td>
          <td><?= htmlspecialchars($s['year_level']) ?></td>
          <td><?= htmlspecialchars($s['student_id']) ?></td>
          <td><?= htmlspecialchars($s['student_status']) ?></td>
          <td><button onclick="showDetails(this)">View / Edit</button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- 📌 Modal -->
<div id="modal" class="modal">
  <div id="modalContent" class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <form method="POST" id="studentForm">
      <div id="studentDetails"></div>
      <div style="margin-top:15px; text-align:right;">
        <button type="submit" name="update_student">Save Changes</button>
        <button type="button" onclick="printID()">Preview ID</button>
      </div>
    </form>
  </div>
</div>

<!-- 🆔 ID Preview Modal -->
<div id="idPreviewModal" class="modal">
  <div class="modal-content" style="max-width: 400px;">
    <span class="close" onclick="closeIdPreview()">&times;</span>
    <div id="idCardPreview"></div>
    <button onclick="confirmPrint()" style="margin-top:10px;">Print ID</button>
  </div>
</div>

<!-- Hidden print-only container -->
<div id="idCard"></div>

<script>
// 🔎 Client-side search
document.getElementById("searchInput").addEventListener("keyup", function() {
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll("#studentsTable tbody tr");
  rows.forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
  });
});

let currentStudent = null;

function showDetails(btn) {
  const row = btn.closest("tr");
  const s = JSON.parse(row.dataset.student);
  currentStudent = s;

  const details = `
    <input type="hidden" name="student_id" value="${s.student_id}">
    <h2>Edit Student: ${s.first_name} ${s.last_name}</h2>

    <p><b>First Name:</b> <input type="text" name="first_name" value="${s.first_name}"></p>
    <p><b>Last Name:</b> <input type="text" name="last_name" value="${s.last_name}"></p>
    <p><b>Birthdate:</b> <input type="date" name="birthdate" value="${s.birthdate || ''}"></p>
    <p><b>Program:</b> <input type="text" name="program" value="${s.program}"></p>
    <p><b>Year Level:</b> <input type="number" name="year_level" value="${s.year_level}"></p>
    <p><b>Status:</b> 
      <select name="student_status">
        <option value="Enrolled" ${s.student_status === "Enrolled" ? "selected" : ""}>Enrolled</option>
        <option value="Dropped" ${s.student_status === "Dropped" ? "selected" : ""}>Dropped</option>
        <option value="Graduated" ${s.student_status === "Graduated" ? "selected" : ""}>Graduated</option>
      </select>
    </p>
    <hr>
    <h3>Guardian Info</h3>
    <p><b>Name:</b> <input type="text" name="guardian_name" value="${s.guardian_name || ''}"></p>
    <p><b>Contact:</b> <input type="text" name="guardian_contact" value="${s.guardian_contact || ''}"></p>
    <p><b>Address:</b> <input type="text" name="guardian_address" value="${s.guardian_address || ''}"></p>
  `;
  document.getElementById("studentDetails").innerHTML = details;
  document.getElementById("modal").style.display = "flex";
}

function closeModal() {
  document.getElementById("modal").style.display = "none";
}

// 🆔 ID Card Print
function printID() {
  if (!currentStudent) return;
  const s = currentStudent;

  const preview = document.getElementById("idCardPreview");
  preview.innerHTML = `
    <div class="id-front">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
        <img src="../components/img/bcpp.png" style="width:40px;height:40px;">
        <div>
          <h3>Bestlink College of the Philippines</h3>
          <small>Student ID</small>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:12px;">
        <img src="${s.photo_path || '../img/default.png'}" alt="Student Photo" style="width:70px;height:90px;border:1px solid #000;">
        <div>
          <p><b>${s.first_name} ${s.last_name}</b></p>
          <p>${s.program} - Year ${s.year_level}</p>
          <p>ID: ${s.student_id}</p>
        </div>
      </div>
    </div>
    <div class="id-back">
      <h3>Student Information</h3>
      <p><b>Guardian:</b> ${s.guardian_name || "N/A"} (${s.guardian_contact || ""})</p>
      <p><b>Address:</b> ${s.guardian_address || "N/A"}</p>
      <br>
      <small>If found, please return to Bestlink College of the Philippines</small>
    </div>
  `;
  document.getElementById("idPreviewModal").style.display = "flex";
}

function closeIdPreview() {
  document.getElementById("idPreviewModal").style.display = "none";
}

function confirmPrint() {
  const idCard = document.getElementById("idCard");
  idCard.innerHTML = document.getElementById("idCardPreview").innerHTML;
  idCard.style.display = "block";
  window.print();
  idCard.style.display = "none";
  idCard.innerHTML = "";
  closeIdPreview();
}
</script>

</body>
</html>
