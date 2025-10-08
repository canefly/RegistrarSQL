
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/functions.php";


function archiveStudent(mysqli $conn, string $student_id, string $final_status, ?int $actor_user_id = null): bool {
    $conn->begin_transaction();
    try {
        $snap = $conn->prepare("
            SELECT
              s.student_id, s.first_name, s.last_name, s.program, s.year_level, s.section,
              s.student_status, s.photo_path,
              (SELECT name FROM guardians WHERE student_id=s.student_id LIMIT 1) AS guardian_name,
              (SELECT contact_no FROM guardians WHERE student_id=s.student_id LIMIT 1) AS guardian_contact,
              (SELECT address FROM guardians WHERE student_id=s.student_id LIMIT 1) AS guardian_address,
              (SELECT primary_school FROM academic_background WHERE student_id=s.student_id LIMIT 1) AS primary_school,
              (SELECT primary_year FROM academic_background WHERE student_id=s.student_id LIMIT 1) AS primary_year,
              (SELECT secondary_school FROM academic_background WHERE student_id=s.student_id LIMIT 1) AS secondary_school,
              (SELECT secondary_year FROM academic_background WHERE student_id=s.student_id LIMIT 1) AS secondary_year,
              (SELECT tertiary_school FROM academic_background WHERE student_id=s.student_id LIMIT 1) AS tertiary_school,
              (SELECT tertiary_year FROM academic_background WHERE student_id=s.student_id LIMIT 1) AS tertiary_year
            FROM students s
            WHERE s.student_id = ?
            FOR UPDATE
        ");
        $snap->bind_param("s", $student_id);
        $snap->execute();
        $data = $snap->get_result()->fetch_assoc();
        $snap->close();

        if (!$data) { throw new RuntimeException("Student not found for archiving."); }

        $data['student_status'] = $final_status;
$ins = $conn->prepare("
    INSERT INTO archived_students
    (student_id, first_name, last_name, program, year_level, section,
     student_status, contact_no, address, birthdate, photo_path)
    VALUES (?,?,?,?,?,?,?,?,?,?,?)
");
$ins->bind_param(
    "sssisssssss",
    $data['student_id'],
    $data['first_name'],
    $data['last_name'],
    $data['program'],
    $data['year_level'],
    $data['section'],
    $data['student_status'],
    $data['contact_no'],
    $data['address'],
    $data['birthdate'],
    $data['photo_path']
);
$ins->execute();
$ins->close();



        $delG = $conn->prepare("DELETE FROM guardians WHERE student_id=?");
        $delG->bind_param("s", $student_id);
        $delG->execute();
        $delG->close();

        $delAB = $conn->prepare("DELETE FROM academic_background WHERE student_id=?");
        $delAB->bind_param("s", $student_id);
        $delAB->execute();
        $delAB->close();

        $delS = $conn->prepare("DELETE FROM students WHERE student_id=?");
        $delS->bind_param("s", $student_id);
        $delS->execute();
        $delS->close();

        if (function_exists('addSystemLog')) {
            addSystemLog(
                $conn,
                'INFO',
                "Archived student {$data['first_name']} {$data['last_name']} (ID: {$student_id}) as {$final_status}",
                'staff/StudentInfo.php',
                $actor_user_id
            );
        }

        $conn->commit();
        return true;
    } catch (Throwable $e) {
    $conn->rollback();
    echo "<pre style='color:red;'>Archive Error: " . $e->getMessage() . "</pre>";
    return false;
}

}

/* ==========================================================
   ARCHIVE POST HANDLER (direct form submit from modal)
========================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_student']) && $_POST['archive_student'] === '1') {
    $student_id   = $_POST['student_id'] ?? '';
    $final_status = trim($_POST['final_status'] ?? 'Dropped');
    $ok = archiveStudent($conn, $student_id, $final_status, $_SESSION['user_id'] ?? null);

    if ($ok) {
        echo "<script>
          window.addEventListener('DOMContentLoaded',function(){
            try{
              showToast('Student archived successfully.');
              // remove row from table instantly
              var rows=document.querySelectorAll('#studentsTable tbody tr[data-student]');
              rows.forEach(function(r){
                try{ var s=JSON.parse(r.dataset.student); if(s.student_id==='".addslashes($student_id)."'){ r.remove(); } }catch(e){}
              });
              // close modals if open
              if (typeof closeModal==='function'){ closeModal('modal'); closeModal('archiveConfirmModal'); }
            }catch(e){}
          });
        </script>";
    } else {
        echo "<script>
          window.addEventListener('DOMContentLoaded',function(){ showToast('Archiving failed. Please try again.', true); });
        </script>";
    }
}

/* ==========================================================
   Handle Student Update (original + server fallback to archive)
========================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
  $student_id       = $_POST['student_id'];
  $first_name       = trim($_POST['first_name'] ?? '');
  $last_name        = trim($_POST['last_name'] ?? '');
  $birthdate        = $_POST['birthdate'] ?? '';
  $program          = trim($_POST['program'] ?? '');
  $validPrograms    = ['Undeclared', 'BSIT', 'BSCS', 'BSECE', 'BSHM', 'BSHRM'];
  if (!in_array($program, $validPrograms)) $program = 'Undeclared';

  $year_level       = (int)($_POST['year_level'] ?? 0);
  $section          = trim($_POST['section'] ?? '');
  $status           = trim($_POST['student_status'] ?? 'Enrolled');
  $guardian_name    = trim($_POST['guardian_name'] ?? '');
  $guardian_contact = trim($_POST['guardian_contact'] ?? '');
  $guardian_address = trim($_POST['guardian_address'] ?? '');
  $primary_school   = trim($_POST['primary_school'] ?? '');
  $primary_year     = trim($_POST['primary_year'] ?? '');
  $secondary_school = trim($_POST['secondary_school'] ?? '');
  $secondary_year   = trim($_POST['secondary_year'] ?? '');
  $tertiary_school  = trim($_POST['tertiary_school'] ?? '');
  $tertiary_year    = trim($_POST['tertiary_year'] ?? '');

  // SERVER-SIDE SAFETY: if Dropped/Graduated, archive instead of update
  if ($status === 'Dropped' || $status === 'Graduated') {
      $ok = archiveStudent($conn, $student_id, $status, $_SESSION['user_id'] ?? null);
      if ($ok) {
          echo "<script>
            window.addEventListener('DOMContentLoaded',function(){
              showToast('Student archived successfully.');
              var rows=document.querySelectorAll('#studentsTable tbody tr[data-student]');
              rows.forEach(function(r){
                try{ var s=JSON.parse(r.dataset.student); if(s.student_id==='".addslashes($student_id)."'){ r.remove(); } }catch(e){}
              });
              if (typeof closeModal==='function'){ closeModal('modal'); closeModal('archiveConfirmModal'); }
            });
          </script>";
      } else {
          echo "<script>window.addEventListener('DOMContentLoaded',function(){ showToast('Archiving failed. Please try again.', true); });</script>";
      }
      // stop further updates
  } else {

      // 🔍 current data snapshot
      $stmtCurrent = $conn->prepare("
        SELECT 
          first_name, last_name, birthdate, program, year_level, section, student_status,
          (SELECT name FROM guardians WHERE student_id = s.student_id LIMIT 1) AS guardian_name,
          (SELECT contact_no FROM guardians WHERE student_id = s.student_id LIMIT 1) AS guardian_contact,
          (SELECT address FROM guardians WHERE student_id = s.student_id LIMIT 1) AS guardian_address,
          (SELECT primary_school FROM academic_background WHERE student_id = s.student_id LIMIT 1) AS primary_school,
          (SELECT primary_year FROM academic_background WHERE student_id = s.student_id LIMIT 1) AS primary_year,
          (SELECT secondary_school FROM academic_background WHERE student_id = s.student_id LIMIT 1) AS secondary_school,
          (SELECT secondary_year FROM academic_background WHERE student_id = s.student_id LIMIT 1) AS secondary_year,
          (SELECT tertiary_school FROM academic_background WHERE student_id = s.student_id LIMIT 1) AS tertiary_school,
          (SELECT tertiary_year FROM academic_background WHERE student_id = s.student_id LIMIT 1) AS tertiary_year,
          s.photo_path
        FROM students s WHERE s.student_id = ?
      ");
      $stmtCurrent->bind_param("s", $student_id);
      $stmtCurrent->execute();
      $current = $stmtCurrent->get_result()->fetch_assoc() ?? [];
      $stmtCurrent->close();

      // ✅ handle photo
      $photo_path = $current['photo_path'] ?? '';
      if (isset($_FILES['student_photo']) && $_FILES['student_photo']['error'] === UPLOAD_ERR_OK) {
          $ext = strtolower(pathinfo($_FILES['student_photo']['name'], PATHINFO_EXTENSION));
          if (in_array($ext, ['jpg','jpeg','png','gif'])) {
              $newFileName = $student_id . '.' . $ext;
              $target = __DIR__ . '/../components/img/ids/' . $newFileName;
              if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $target)) {
                  if ($photo_path !== $newFileName) {
                      $photo_path = $newFileName;
                      addSystemLog($conn, 'INFO', "Updated student photo for {$student_id}", 'staff/StudentInfo.php', $_SESSION['user_id']);
                  }
              }
          }
      }

      // === PERSONAL DETAILS ===
      foreach ($current as $key => $val) { if (is_null($val)) { $current[$key] = ''; } }

      $personalChanged = (
          trim((string)$current['first_name']) !== $first_name ||
          trim((string)$current['last_name']) !== $last_name ||
          trim((string)$current['birthdate']) !== $birthdate ||
          trim((string)$current['program']) !== $program ||
          (int)$current['year_level'] !== (int)$year_level ||
          trim((string)$current['section']) !== $section ||
          trim((string)$current['student_status']) !== $status
      );

      if ($personalChanged) {
          $stmt = $conn->prepare("UPDATE students 
            SET first_name=?, last_name=?, birthdate=?, program=?, year_level=?, section=?, student_status=?, photo_path=? 
            WHERE student_id=?");
          $stmt->bind_param(
              "ssssissss",
              $first_name,
              $last_name,
              $birthdate,
              $program,
              $year_level,
              $section,
              $status,
              $photo_path,
              $student_id
          );
          $stmt->execute();

          addSystemLog(
              $conn,
              'INFO',
              "Updated personal details for {$first_name} {$last_name} (ID: {$student_id})",
              'staff/StudentInfo.php',
              $_SESSION['user_id']
          );
      }

      // === GUARDIAN INFO ===
      $guardianChanged = (
          trim((string)$current['guardian_name']) !== $guardian_name ||
          trim((string)$current['guardian_contact']) !== $guardian_contact ||
          trim((string)$current['guardian_address']) !== $guardian_address
      );

      if ($guardianChanged) {
          $res = $conn->prepare("SELECT guardian_id FROM guardians WHERE student_id=?");
          $res->bind_param("s", $student_id);
          $res->execute();
          $check = $res->get_result();
          if ($check->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE guardians SET name=?, contact_no=?, address=? WHERE student_id=?");
              $stmt->bind_param("ssss", $guardian_name, $guardian_contact, $guardian_address, $student_id);
              $stmt->execute();
              addSystemLog($conn, 'INFO', "Updated guardian info for student {$student_id}", 'staff/StudentInfo.php', $_SESSION['user_id']);
          } else {
              $stmt = $conn->prepare("INSERT INTO guardians (student_id, name, contact_no, address) VALUES (?, ?, ?, ?)");
              $stmt->bind_param("ssss", $student_id, $guardian_name, $guardian_contact, $guardian_address);
              $stmt->execute();
              addSystemLog($conn, 'INFO', "Added guardian info for student {$student_id}", 'staff/StudentInfo.php', $_SESSION['user_id']);
          }
      }

      // === ACADEMIC BACKGROUND ===
      $academicChanged = (
          trim((string)$current['primary_school']) !== $primary_school ||
          trim((string)$current['primary_year']) !== $primary_year ||
          trim((string)$current['secondary_school']) !== $secondary_school ||
          trim((string)$current['secondary_year']) !== $secondary_year ||
          trim((string)$current['tertiary_school']) !== $tertiary_school ||
          trim((string)$current['tertiary_year']) !== $tertiary_year
      );

      if ($academicChanged) {
          $res = $conn->prepare("SELECT id FROM academic_background WHERE student_id=?");
          $res->bind_param("s", $student_id);
          $res->execute();
          $check = $res->get_result();
          $res->close();
          if ($check->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE academic_background 
                  SET primary_school=?, primary_year=?, secondary_school=?, secondary_year=?, tertiary_school=?, tertiary_year=? 
                  WHERE student_id=?");
              $stmt->bind_param("sssssss", $primary_school, $primary_year, $secondary_school, $secondary_year, $tertiary_school, $tertiary_year, $student_id);
              $stmt->execute();
              addSystemLog($conn, 'INFO', "Updated academic background for student {$student_id}", 'staff/StudentInfo.php', $_SESSION['user_id']);
          } else {
              $stmt = $conn->prepare("INSERT INTO academic_background 
                  (student_id, primary_school, primary_year, secondary_school, secondary_year, tertiary_school, tertiary_year) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)");
              $stmt->bind_param("sssssss", $student_id, $primary_school, $primary_year, $secondary_school, $secondary_year, $tertiary_school, $tertiary_year);
              $stmt->execute();
              addSystemLog($conn, 'INFO', "Added academic background for student {$student_id}", 'staff/StudentInfo.php', $_SESSION['user_id']);
          }
      }

      echo "<script>alert('Student record updated successfully!');</script>";
  } // end else (not Dropped/Graduated)
}

/* ======================
   Fetch Students
====================== */
$resAll = $conn->query(
  "SELECT
    s.student_id,
    s.first_name,
    s.last_name,
    s.program,
    s.year_level,
    s.section,
    s.student_status,
    g.name AS guardian_name,
    g.contact_no AS guardian_contact,
    g.address AS guardian_address,
    s.birthdate,
    s.gender,
    s.photo_path,
    ab.primary_school,
    ab.primary_year,
    ab.secondary_school,
    ab.secondary_year,
    ab.tertiary_school,
    ab.tertiary_year
  FROM students s
  LEFT JOIN guardians g ON s.student_id = g.student_id
  LEFT JOIN academic_background ab ON s.student_id = ab.student_id
  ORDER BY s.last_name ASC"
);
$allStudents = $resAll->fetch_all(MYSQLI_ASSOC);
$students = array_slice($allStudents, 0, 50);

foreach ($allStudents as &$s) {
  foreach ([
    'guardian_name','guardian_contact','guardian_address',
    'photo_path','section','primary_school','primary_year',
    'secondary_school','secondary_year','tertiary_school','tertiary_year'
  ] as $field) {
    $s[$field] = $s[$field] ?? '';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Records</title>
  <link rel="stylesheet" href="../components/css/StudentInfo.css">
  <link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
  <link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
  <style>
    .suggestions { 
      border: 1px solid #ccc; 
      max-height: 150px; 
      overflow-y: auto; 
      background: white; 
      position: absolute; 
      width: 300px; 
      z-index: 1000;
    }
    .suggestions div { padding: 5px; cursor: pointer; }
    .suggestions div:hover { background: #eee; }
    .id-front, .id-back {
      width: 85.6mm; height: 54mm;
      border: 1px solid #000; border-radius: 6px;
      background: url('../components/img/bgid.jpg') no-repeat center/cover;
      padding: 8px; box-sizing: border-box; font-size: 12px;
    }
    #qrcode canvas, #qrcode img {
      width: 100px !important; height: 100px !important;
      margin: auto; display: block;
    }
  </style>
</head>
<body>
<?php include 'StaffSidenav.php'; ?>
<div class="container">
  <h1>Student Records</h1>
  <p>Manage student information, update records, and print student IDs.</p>

  <!-- Search -->
  <div style="position:relative;">
    <input type="text" id="searchInput" placeholder="Search student..." autocomplete="off">
    <div id="suggestionsBox" class="suggestions" style="display:none;"></div>
  </div>

  <!-- Student Table -->
  <div class="table-wrapper">
    <table id="studentsTable">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Program</th>
        <th>Year Level</th>
        <th>Section</th>
        <th>Student ID</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
  <tbody id="studentsBody">
  <?php foreach ($students as $s): ?>
    <tr data-student='<?= json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
      <td><?= htmlspecialchars($s['last_name'] . ", " . $s['first_name']) ?></td>
      <td><?= htmlspecialchars($s['program']) ?></td>
      <td><?= htmlspecialchars($s['year_level']) ?></td>
      <td><?= htmlspecialchars($s['section']) ?></td>
      <td><?= htmlspecialchars($s['student_id']) ?></td>
      <td><?= htmlspecialchars($s['student_status']) ?></td>
       <td>
          <button onclick="viewStudent(this)">View</button>
          <button onclick="showDetails(this)">Edit</button>
        </td>
    </tr>
  <?php endforeach; ?>

  <!-- 🔹 Hidden by default, shown when no match -->
  <tr id="noResultsRow" style="display:none;">
    <td colspan="7" style="text-align:center; color:#666; padding:20px;">
      No students found.
    </td>
  </tr>
</tbody>
  </table>
</div>

<!-- Modal -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('modal')">&times;</span>
    <form method="POST" id="studentForm" enctype="multipart/form-data">
      <div id="studentDetails"></div>
      <div style="margin-top:15px; text-align:right;">
        <button type="submit" name="update_student">Save Changes</button>
        <button type="button" onclick="printID()">Preview ID</button>
      </div>
    </form>
  </div>
</div>

<!-- ID Preview Modal -->
<div id="idPreviewModal" class="modal">
  <div class="modal-content" style="max-width: 400px;">
    <span class="close" onclick="closeModal('idPreviewModal')">&times;</span>
    <div id="idCardPreview"></div>
    <button onclick="confirmPrint()" style="margin-top:10px;">Print ID</button>
  </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal">
  <div class="modal-content" style="max-width: 700px;">
    <span class="close" onclick="closeModal('viewModal')">&times;</span>
    <div id="viewStudentDetails"></div>
  </div>
</div>

<!-- Archive Confirm Modal -->
<div id="archiveConfirmModal" class="modal">
  <div class="modal-content" style="max-width: 520px;">
    <span class="close" onclick="closeModal('archiveConfirmModal')">&times;</span>
    <div id="archiveConfirmBody" style="padding:8px 2px; line-height:1.5;"></div>
    <form method="POST" id="archiveForm">
      <input type="hidden" name="archive_student" value="1">
      <input type="hidden" name="student_id" id="archive_student_id">
      <input type="hidden" name="final_status" id="archive_final_status">
      <div style="margin-top:16px; text-align:right;">
        <button type="button" onclick="closeModal('archiveConfirmModal')" style="margin-right:8px;">Cancel</button>
        <button type="submit" style="background:#1e40af;color:#fff;padding:6px 12px;border:none;border-radius:6px;">Confirm</button>
      </div>
    </form>
  </div>
</div>

<!-- Toast -->
<div id="toastBox" style="position:fixed;top:16px;right:16px;z-index:9999;"></div>

<div id="idCard" style="display:none;"></div>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
let currentStudent = null;
const allStudents = <?= json_encode($allStudents, JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
const searchInput = document.getElementById("searchInput");
const suggestionsBox = document.getElementById("suggestionsBox");

searchInput.addEventListener("keyup", function () {
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll("#studentsTable tbody tr[data-student]");
  const noResultsRow = document.getElementById("noResultsRow");
  const suggestionsBox = document.getElementById("suggestionsBox");
  let visibleCount = 0;
  let matches = [];

  rows.forEach(row => {
    const student = JSON.parse(row.dataset.student);
    const fullName = (student.last_name + ", " + student.first_name).toLowerCase();
    const id = student.student_id.toLowerCase();
    const program = student.program.toLowerCase();

    if (fullName.includes(filter) || id.includes(filter) || program.includes(filter)) {
      row.style.display = "";
      visibleCount++;
      matches.push(student);
    } else {
      row.style.display = "none";
    }
  });

  document.addEventListener('click', (e) => {
    if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
      suggestionsBox.style.display = 'none';
    }
  });

  noResultsRow.style.display = visibleCount === 0 ? "table-row" : "none";

  suggestionsBox.innerHTML = "";
  if (matches.length > 0 && filter.length > 0) {
    suggestionsBox.style.display = "block";
    matches.slice(0, 5).forEach(m => {
      const div = document.createElement("div");
      const name = `${m.last_name}, ${m.first_name} (${m.student_id})`;
      div.innerHTML = name.replace(new RegExp(`(${filter})`, "gi"), "<b>$1</b>");
      div.style.padding = "8px 10px";
      div.style.cursor = "pointer";
      div.style.transition = "background 0.2s";
      div.onmouseover = () => (div.style.background = "#f1f5ff");
      div.onmouseout  = () => (div.style.background = "white");
      div.onclick = () => {
        const matchRow = Array.from(rows).find(r => JSON.parse(r.dataset.student).student_id === m.student_id);
        if (matchRow) showDetails(matchRow.querySelector("button"));
        suggestionsBox.style.display = "none";
      };
      suggestionsBox.appendChild(div);
    });
  } else {
    suggestionsBox.style.display = "none";
  }
});

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
    <p><b>Program:</b> 
    <select name="program" required>
        <option value="">-- Select Program --</option>
        <option value="BSIT" ${s.program === "BSIT" ? "selected" : ""}>BSIT - Bachelor of Science in Information Technology</option>
        <option value="BSCS" ${s.program === "BSCS" ? "selected" : ""}>BSCS - Bachelor of Science in Computer Science</option>
        <option value="BSECE" ${s.program === "BSECE" ? "selected" : ""}>BSECE - Bachelor of Science in Electronics Engineering</option>
        <option value="BSHM" ${s.program === "BSHM" ? "selected" : ""}>BSHM - Bachelor of Science in Hospitality Management</option>
        <option value="BSHRM" ${s.program === "BSHRM" ? "selected" : ""}>BSHRM - Bachelor of Science in Hotel & Restaurant Management</option>
        <option value="Undeclared" ${s.program === "Undeclared" ? "selected" : ""}>Undeclared</option>
      </select>
    </p>

    <p><b>Year Level:</b> <input type="number" name="year_level" value="${s.year_level}"></p>
    <p><b>Section:</b> <input type="text" name="section" value="${s.section}"></p>
    <p><b>Status:</b>
      <select name="student_status" onchange="handleStatusChange(this)">
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
  document.getElementById("modal").style.display = "flex";
}

function viewStudent(btn) {
  const row = btn.closest("tr");
  const s = JSON.parse(row.dataset.student);
  currentStudent = s;

  const photo = s.photo_path
    ? `<img src="../components/img/ids/${s.photo_path}" alt="Student Photo" style="width:140px;height:160px;border:1px solid #000;border-radius:8px;object-fit:cover;">`
    : `<div style="width:140px;height:160px;border:1px dashed #999;display:flex;align-items:center;justify-content:center;border-radius:8px;color:#777;font-style:italic;">No Photo</div>`;

  const content = `
    <h2 style="text-align:center;margin-bottom:20px;color:#1e3a8a;">Student Information</h2>
    <div style="display:flex;gap:25px;align-items:flex-start;justify-content:center;">
      <div style="flex:0 0 160px;text-align:center;">
        <h4 style="margin-bottom:8px;">Student Photo</h4>
        ${photo}
      </div>
      <div style="flex:1;">
        <p><b>Student ID:</b> ${s.student_id}</p>
        <p><b>Name:</b> ${s.first_name} ${s.last_name}</p>
        <p><b>Birthdate:</b> ${s.birthdate || 'N/A'}</p>
        <p><b>Program:</b> ${s.program}</p>
        <p><b>Year Level:</b> ${s.year_level}</p>
        <p><b>Section:</b> ${s.section}</p>
        <p><b>Status:</b> ${s.student_status}</p>
      </div>
    </div>
    <hr style="margin:20px 0;">
    <h3 style="color:#1e3a8a;">Guardian Information</h3>
    <p><b>Name:</b> ${s.guardian_name || 'N/A'}</p>
    <p><b>Contact:</b> ${s.guardian_contact || 'N/A'}</p>
    <p><b>Address:</b> ${s.guardian_address || 'N/A'}</p>
    <hr style="margin:20px 0;">
    <h3 style="color:#1e3a8a;">Academic Background</h3>
    <p><b>Primary:</b> ${s.primary_school || 'N/A'} (${s.primary_year || ''})</p>
    <p><b>Secondary:</b> ${s.secondary_school || 'N/A'} (${s.secondary_year || ''})</p>
    <p><b>Tertiary:</b> ${s.tertiary_school || 'N/A'} (${s.tertiary_year || ''})</p>
  `;
  document.getElementById("viewStudentDetails").innerHTML = content;
  document.getElementById("viewModal").style.display = "flex";
}

function openModal(id) {
  var m=document.getElementById(id);
  if(m){ m.style.display = "flex"; document.body.classList.add("modal-open"); }
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.style.display = "none";
    document.body.classList.remove("modal-open");
  }
}

function printID() {
  if (!currentStudent) return;
  const s = currentStudent;
  const preview = document.getElementById("idCardPreview");
  const photo = s.photo_path ? `../components/img/ids/${s.photo_path}` : "../components/img/ids/default.jpg";
  preview.innerHTML = `
    <div class="id-front">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
        <img src="../components/img/bcpp.png" style="width:40px;height:40px;">
        <div><h3 style="margin:0;">Bestlink College of the Philippines</h3><small>Student ID</small></div>
      </div>
      <div style="display:flex;align-items:center;gap:12px;">
        <img src="${photo}" alt="Student Photo" style="width:70px;height:90px;border:1px solid #000;">
        <div>
          <p><b>${s.first_name} ${s.last_name}</b></p>
          <p>${s.program} - Year ${s.year_level}</p>
          <p>Section: ${s.section}</p>
          <p>ID: ${s.student_id}</p>
        </div>
      </div>
    </div>
    <div class="id-back">
      <div class="id-back-info">
        <p><b>In Case of Emergency</b></p>
        <p><span>Guardian:</span> ${s.guardian_name}</p>
        <p><span>Contact:</span> ${s.guardian_contact}</p>
        <p><span>Address:</span> ${s.guardian_address}</p>
      </div>
      <div id="qrcode"></div>
    </div>`;
  new QRCode(document.getElementById("qrcode"), {
    text: `ID: ${s.student_id}\nName: ${s.first_name} ${s.last_name}\nProgram: ${s.program}\nYear: ${s.year_level} Section: ${s.section}\nGuardian: ${s.guardian_name} (${s.guardian_contact})\nAddress: ${s.guardian_address}`,
    width: 100, height: 100
  });
  document.getElementById("idPreviewModal").style.display = "flex";
}

function confirmPrint() { window.print(); }

/* =======================
   Toast + Archive JS
======================= */
function showToast(msg, isError=false){
  const box = document.getElementById('toastBox');
  const t = document.createElement('div');
  t.textContent = msg;
  t.style.padding = '10px 14px';
  t.style.marginTop = '8px';
  t.style.borderRadius = '8px';
  t.style.boxShadow = '0 4px 12px rgba(0,0,0,.12)';
  t.style.background = isError ? '#ef4444' : '#16a34a';
  t.style.color = '#fff';
  t.style.fontSize = '14px';
  t.style.opacity = '0';
  t.style.transition = 'opacity .2s, transform .2s';
  t.style.transform = 'translateY(-6px)';
  box.appendChild(t);
  requestAnimationFrame(()=>{ t.style.opacity='1'; t.style.transform='translateY(0)';});
  setTimeout(()=>{
    t.style.opacity='0'; t.style.transform='translateY(-6px)';
    setTimeout(()=> box.removeChild(t), 200);
  }, 3000);
}

/* Fire modal immediately when status is changed */
function handleStatusChange(sel){
  const val = sel.value;
  if (!currentStudent) return;
  if (val === 'Dropped' || val === 'Graduated'){
    document.getElementById('archive_student_id').value = currentStudent.student_id;
    document.getElementById('archive_final_status').value = val;
    document.getElementById('archiveConfirmBody').innerHTML = `
      <h2 style="margin:0 0 8px 0; color:#1e3a8a;">Confirm Status Change</h2>
      <p style="margin:0 0 8px 0;">You are setting <b>${currentStudent.first_name} ${currentStudent.last_name}</b> (ID: <b>${currentStudent.student_id}</b>) to <b>${val}</b>.</p>
      <p style="margin:0 0 8px 0;">Once confirmed, this student’s complete record will be <b>moved to the Archive</b>. It will no longer appear on the staff list and will be accessible only to authorized administrators.</p>
      <p style="margin:0;">Please confirm to proceed.</p>`;
    // show modal (robustly)
    var m=document.getElementById('archiveConfirmModal');
    if (m){ m.style.display='flex'; }
    if (typeof openModal==='function'){ openModal('archiveConfirmModal'); }
  }
}

/* Also intercept Save button: if Dropped/Graduated, stop normal submit and open modal */
document.addEventListener('submit', function(e){
  const form = e.target;
  if (form && form.id === 'studentForm'){
    const sel = form.querySelector('select[name="student_status"]');
    if (sel){
      const val = sel.value;
      if (val === 'Dropped' || val === 'Graduated'){
        e.preventDefault(); // stop normal update
        handleStatusChange(sel); // open confirm modal
      }
    }
  }
});
</script>
</body>
</html>
