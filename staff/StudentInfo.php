<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";

/* ======================
   Handle Student Update
====================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $student_id       = $_POST['student_id'];
    $first_name       = $_POST['first_name'] ?? '';
    $last_name        = $_POST['last_name'] ?? '';
    $birthdate        = $_POST['birthdate'] ?? '';
    $program = trim($_POST['program'] ?? '');
    $validPrograms = ['Undeclared', 'BSIT', 'BSCS', 'BSECE'];
    if (!in_array($program, $validPrograms)) {
        $program = 'Undeclared';
    }
    $year_level       = (int)($_POST['year_level'] ?? 0);
    $section          = $_POST['section'] ?? '';
    $status           = $_POST['student_status'] ?? 'Enrolled';
    $guardian_name    = $_POST['guardian_name'] ?? '';
    $guardian_contact = $_POST['guardian_contact'] ?? '';
    $guardian_address = $_POST['guardian_address'] ?? '';
    $primary_school   = $_POST['primary_school'] ?? '';
    $primary_year     = $_POST['primary_year'] ?? '';
    $secondary_school = $_POST['secondary_school'] ?? '';
    $secondary_year   = $_POST['secondary_year'] ?? '';
    $tertiary_school  = $_POST['tertiary_school'] ?? '';
    $tertiary_year    = $_POST['tertiary_year'] ?? '';

    // Handle photo
    $photo_path = '';
    $resPhoto = $conn->prepare("SELECT photo_path FROM students WHERE student_id=?");
    $resPhoto->bind_param("s", $student_id);
    $resPhoto->execute();
    $resultPhoto = $resPhoto->get_result();
    $current_photo = $resultPhoto->num_rows > 0 ? $resultPhoto->fetch_assoc()['photo_path'] : '';
    

    if (isset($_FILES['student_photo']) && $_FILES['student_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['student_photo']['tmp_name'];
        $fileName = $_FILES['student_photo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg','jpeg','png','gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = $student_id . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../components/img/ids/';
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $photo_path = $newFileName;
            } else {
                $photo_path = $current_photo;
            }
        } else {
            $photo_path = $current_photo;
        }
    } else {
        $photo_path = $current_photo;
    }

    // Update students
    $stmt = $conn->prepare("UPDATE students SET first_name=?, last_name=?, birthdate=?, program=?, year_level=?, section=?, student_status=?, photo_path=? WHERE student_id=?");
    $stmt->bind_param("ssssissss", $first_name, $last_name, $birthdate, $program, $year_level, $section, $status, $photo_path, $student_id);

    $stmt->execute();

    // Update or insert guardian
    $res = $conn->prepare("SELECT guardian_id FROM guardians WHERE student_id=?");
    $res->bind_param("s", $student_id);
    $res->execute();
    $result = $res->get_result();
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE guardians SET name=?, contact_no=?, address=? WHERE student_id=?");
        $stmt->bind_param("ssss", $guardian_name, $guardian_contact, $guardian_address, $student_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO guardians (student_id, name, contact_no, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_id, $guardian_name, $guardian_contact, $guardian_address);
        $stmt->execute();
    }

    // Academic background
    $res = $conn->prepare("SELECT id FROM academic_background WHERE student_id=?");
    $res->bind_param("s", $student_id);
    $res->execute();
    $result = $res->get_result();
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE academic_background SET primary_school=?, primary_year=?, secondary_school=?, secondary_year=?, tertiary_school=?, tertiary_year=? WHERE student_id=?");
        $stmt->bind_param("sssssss", $primary_school, $primary_year, $secondary_school, $secondary_year, $tertiary_school, $tertiary_year, $student_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO academic_background (student_id, primary_school, primary_year, secondary_school, secondary_year, tertiary_school, tertiary_year) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $student_id, $primary_school, $primary_year, $secondary_school, $secondary_year, $tertiary_school, $tertiary_year);
        $stmt->execute();
    }
    
    echo "<script>alert('Student record updated successfully!');</script>";
}

/* ======================
   Fetch Students
====================== */
$resAll = $conn->query("SELECT s.student_id, s.first_name, s.last_name, s.program, s.year_level, s.section, s.student_status,
  g.name AS guardian_name, g.contact_no AS guardian_contact, g.address AS guardian_address,
  s.birthdate, s.gender, s.photo_path,
  ab.primary_school, ab.primary_year, ab.secondary_school, ab.secondary_year, ab.tertiary_school, ab.tertiary_year
  FROM students s
  LEFT JOIN guardians g ON s.student_id = g.student_id
  LEFT JOIN academic_background ab ON s.student_id = ab.student_id
  ORDER BY s.last_name ASC");
$allStudents = $resAll->fetch_all(MYSQLI_ASSOC);
$students = is_array($allStudents) ? array_slice($allStudents, 0, 50) : [];

foreach ($allStudents as &$s) {
  foreach (['guardian_name','guardian_contact','guardian_address','photo_path','section','primary_school','primary_year','secondary_school','secondary_year','tertiary_school','tertiary_year'] as $f) {
      $s[$f] = $s[$f] ?? '';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Records</title>
<link rel="stylesheet" href="../components/css/StudentInfo.css">
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<style>
.modal { display:none; position:fixed; top:0; left:0;width:100%;height:100%;background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
.modal-content { background:#fff; padding:20px; border-radius:6px; max-height:90%; overflow-y:auto; }
.suggestions { border:1px solid #ccc; max-height:150px; overflow-y:auto; background:white; position:absolute; width:300px; z-index:1000; }
.suggestions div { padding:5px; cursor:pointer; }
.suggestions div:hover { background:#eee; }
.id-front, .id-back { width:85.6mm; height:54mm; border:1px solid #000; border-radius:6px; background:url('../components/img/bgid.jpg') no-repeat center/cover; padding:8px; box-sizing:border-box; font-size:12px; }
#qrcode canvas, #qrcode img { width:100px !important; height:100px !important; margin:auto; display:block; }
</style>
</head>
<body>
<?php include 'StaffSidenav.php'; ?>
<div class="container">
<h1>Student Records</h1>
<input type="text" id="searchInput" placeholder="Search student..." autocomplete="off">
<div id="suggestionsBox" class="suggestions" style="display:none;"></div>

<table id="studentsTable">
<thead>
<tr>
<th>Student Name</th><th>Program</th><th>Year Level</th><th>Section</th><th>Student ID</th><th>Status</th><th>Action</th>
</tr>
</thead>
<tbody>
<?php if($students): foreach($students as $s): ?>
<tr data-student='<?= json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
<td><?= htmlspecialchars($s['last_name'] . ", " . $s['first_name']) ?></td>
<td><?= htmlspecialchars($s['program']) ?></td>
<td><?= htmlspecialchars($s['year_level']) ?></td>
<td><?= htmlspecialchars($s['section']) ?></td>
<td><?= htmlspecialchars($s['student_id']) ?></td>
<td><?= htmlspecialchars($s['student_status']) ?></td>
<td><button onclick="showDetails(this)">Edit</button></td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</div>

<!-- Edit Modal -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeMainModal()">&times;</span>
<form method="POST" id="studentForm" enctype="multipart/form-data">
<div id="studentDetails"></div>
<div style="margin-top:15px; text-align:right;">
<button type="submit" name="update_student">Save Changes</button>
<button type="button" onclick="printID()">Preview ID</button>
</div>
</form>
</div>
</div>

<!-- ID Preview -->
<div id="idPreviewModal" class="modal">
  <div class="modal-content" style="max-width: 430px;">
    <span class="close" onclick="closeIdPreview()">&times;</span>
<div id="idCardPreview"></div>
<button onclick="confirmPrint()" style="margin-top:10px;">Print ID</button>
</div>
</div>

<div id="idCard" style="display:none;"></div>
<script>
/* ---------------------------
   STATE
--------------------------- */
let currentStudent = null;
const allStudents = <?= json_encode($allStudents, JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
const searchInput = document.getElementById("searchInput");
const suggestionsBox = document.getElementById("suggestionsBox");

/* ---------------------------
   MODAL HELPERS
--------------------------- */
function openModal(id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.style.display = "flex";
  document.body.classList.add("modal-open"); // prevents background scroll
}
function closeModal(id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.style.display = "none";
  document.body.classList.remove("modal-open");
}
// click outside to close
document.addEventListener("click", (e) => {
  const main = document.getElementById("modal");
  const prev = document.getElementById("idPreviewModal");
  if (main && main.style.display === "flex" && e.target === main) closeModal("modal");
  if (prev && prev.style.display === "flex" && e.target === prev) closeModal("idPreviewModal");
});
// Esc to close
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    closeModal("modal");
    closeModal("idPreviewModal");
  }
});

/* ---------------------------
   RENDER EDIT FORM (shared)
--------------------------- */
function openEditModalFor(s) {
  currentStudent = s;

  const details = `
    <input type="hidden" name="student_id" value="${s.student_id}">
    <h2>Edit Student: ${s.first_name} ${s.last_name}</h2>
    <p><b>First Name:</b> <input type="text" name="first_name" value="${s.first_name}"></p>
    <p><b>Last Name:</b> <input type="text" name="last_name" value="${s.last_name}"></p>
    <p><b>Birthdate:</b> <input type="date" name="birthdate" value="${s.birthdate || ''}"></p>
    <p><b>Program:</b> <input type="text" name="program" value="${s.program}"></p>
    <p><b>Year Level:</b> <input type="number" name="year_level" value="${s.year_level}"></p>
    <p><b>Section:</b> <input type="text" name="section" value="${s.section}"></p>
    <p><b>Status:</b>
      <select name="student_status">
        <option value="Enrolled" ${s.student_status === "Enrolled" ? "selected" : ""}>Enrolled</option>
        <option value="Dropped" ${s.student_status === "Dropped" ? "selected" : ""}>Dropped</option>
        <option value="Graduated" ${s.student_status === "Graduated" ? "selected" : ""}>Graduated</option>
      </select>
    </p>
    <hr>
    <h3>Photo</h3>
    <p><b>Photo:</b> 
      <input type="file" name="student_photo" accept="image/*">
      ${s.photo_path ? `<br><img src="../components/img/ids/${s.photo_path}" style="width:70px;height:90px;border:1px solid #000;margin-top:5px;">` : ''}
    </p>
    <hr>
    <h3>Guardian Info</h3>
    <p><b>Name:</b> <input type="text" name="guardian_name" value="${s.guardian_name}"></p>
    <p><b>Contact:</b> <input type="text" name="guardian_contact" value="${s.guardian_contact}"></p>
    <p><b>Address:</b> <input type="text" name="guardian_address" value="${s.guardian_address}"></p>
    <hr>
    <h3>Academic Background</h3>
    <p><b>Primary School:</b> <input type="text" name="primary_school" value="${s.primary_school}"></p>
    <p><b>Year:</b> <input type="text" name="primary_year" value="${s.primary_year}"></p>
    <p><b>Secondary School:</b> <input type="text" name="secondary_school" value="${s.secondary_school}"></p>
    <p><b>Year:</b> <input type="text" name="secondary_year" value="${s.secondary_year}"></p>
    <p><b>Tertiary School:</b> <input type="text" name="tertiary_school" value="${s.tertiary_school}"></p>
    <p><b>Year:</b> <input type="text" name="tertiary_year" value="${s.tertiary_year}"></p>
  `;
  document.getElementById("studentDetails").innerHTML = details;
  openModal("modal");
}

/* ---------------------------
   TABLE: Edit button → shared
--------------------------- */
function showDetails(btn) {
  const row = btn.closest("tr");
  const s = JSON.parse(row.dataset.student);
  openEditModalFor(s);
}

/* ---------------------------
   SEARCH SUGGESTIONS
--------------------------- */
searchInput.addEventListener("keyup", function() {
  const filter = this.value.trim().toLowerCase();
  let matches = [];

  if (filter.length > 0) {
    allStudents.forEach(s => {
      const fullName = (s.last_name + ", " + s.first_name).toLowerCase();
      if (fullName.includes(filter)) matches.push(s);
    });
  }

  suggestionsBox.innerHTML = "";
  suggestionsBox.style.display = (matches.length > 0) ? "block" : "none";

  matches.slice(0, 8).forEach(m => {
    const div = document.createElement("div");
    const regex = new RegExp("(" + filter.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ")", "i");
    const name = m.last_name + ", " + m.first_name;
    div.innerHTML = name.replace(regex, "<b>$1</b>");
    div.onclick = () => {
      // open the SAME Edit modal as the table button
      openEditModalFor(m);
      suggestionsBox.style.display = "none";
      this.value = name; // keep selected text
    };
    suggestionsBox.appendChild(div);
  });
});

/* ---------------------------
   CLOSE HOOKS (buttons)
--------------------------- */
function closeMainModal(){ closeModal("modal"); }
function closeIdPreview(){ closeModal("idPreviewModal"); }

/* ---------------------------
   ID PREVIEW (unchanged logic)
--------------------------- */
function printID() {
  if (!currentStudent) return;
  const s = currentStudent;
  const preview = document.getElementById("idCardPreview");
  const photo = s.photo_path ? `../components/img/ids/${s.photo_path}` : "../components/img/ids/default.jpg";

  preview.innerHTML = `
    <div class="id-front">
      <div class="id-front-header">
        <img src="../components/img/bcpp.png" alt="">
        <div>
          <h3>Bestlink College of the Philippines</h3>
          <small>Student ID</small>
        </div>
      </div>
      <div class="id-front-body">
        <img src="${photo}" alt="Student Photo">
        <div>
          <p><b>${s.first_name} ${s.last_name}</b></p>
          <p>${s.program || 'Undeclared'} - Year ${s.year_level || ''}</p>
          <p>Section: ${s.section || ''}</p>
          <p>ID: ${s.student_id}</p>
        </div>
      </div>
    </div>
    <div class="id-back">
      <p>
        In Case of emergency Guardian: ${s.guardian_name || ''} (${s.guardian_contact || ''})<br>
        Address: ${s.guardian_address || ''}
      </p>
      <div id="qrcode"></div>
    </div>
  `;

  // fresh QR each time
  const qrEl = document.getElementById("qrcode");
  qrEl.innerHTML = "";
  new QRCode(qrEl, {
    text: `ID: ${s.student_id}\nName: ${s.first_name} ${s.last_name}\nProgram: ${s.program}\nYear: ${s.year_level} Section: ${s.section}\nGuardian: ${s.guardian_name} (${s.guardian_contact})\nAddress: ${s.guardian_address}`,
    width: 100,
    height: 100
  });

  openModal("idPreviewModal");
}

function confirmPrint() {
  const idCard = document.getElementById("idCard");
  idCard.innerHTML = document.getElementById("idCardPreview").innerHTML;
  idCard.style.display = "flex";
  idCard.style.flexDirection = "row";
  idCard.style.justifyContent = "center";
  idCard.style.gap = "20px";
  window.print();
  idCard.style.display = "none";
  idCard.innerHTML = "";
  closeModal("idPreviewModal");
}
</script>


</body>
</html>
