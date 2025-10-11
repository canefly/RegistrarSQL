<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/functions.php";
requireRole("Employee");


      

/* ==================================================
   FETCH ARCHIVED STUDENTS + FILES
================================================== */
$res = $conn->query("
  SELECT 
    a.student_id,
    a.first_name,
    a.last_name,
    a.program,
    a.year_level,
    a.section,
    a.student_status,
    a.birthdate,
    a.photo_path,
    a.archived_date,
    g.name AS guardian_name,
    g.contact_no AS guardian_contact,
    g.address AS guardian_address,
    ab.primary_school,
    ab.primary_year,
    ab.secondary_school,
    ab.secondary_year,
    ab.tertiary_school,
    ab.tertiary_year,
    GROUP_CONCAT(CONCAT(f.file_type, '|', f.file_path) SEPARATOR '||') AS archived_files
  FROM archived_students a
  LEFT JOIN archived_guardians g ON a.student_id = g.student_id
  LEFT JOIN archived_academic_background ab ON a.student_id = ab.student_id
  LEFT JOIN archived_file_storage f ON a.student_id = f.student_id
  GROUP BY a.student_id
  ORDER BY a.archived_date DESC, a.last_name ASC
");
$archivedStudents = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Archived Students</title>
  <link rel="stylesheet" href="../components/css/StudentInfo.css">
  <link rel="icon" href="../components/img/bcpp.png" type="image/png">
</head>
<body>
<?php include 'StaffSidenav.php'; ?>

<div class="container">
  <h1>Archived Students</h1>
  <p>View or recover archived student records.</p>

  <!-- Search -->
  <div style="position:relative;">
    <input type="text" id="searchInput" placeholder="Search archived student..." autocomplete="off">
    <div id="suggestionsBox" class="suggestions" style="display:none;"></div>
  </div>

  <!-- Table -->
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
          <th>Date Archived</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($archivedStudents) === 0): ?>
          <tr><td colspan="8" style="text-align:center;">No archived records found.</td></tr>
        <?php else: foreach ($archivedStudents as $s): ?>
          <tr data-student='<?= json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
            <td><?= htmlspecialchars($s['last_name'] . ", " . $s['first_name']) ?></td>
            <td><?= htmlspecialchars($s['program']) ?></td>
            <td><?= htmlspecialchars($s['year_level']) ?></td>
            <td><?= htmlspecialchars($s['section']) ?></td>
            <td><?= htmlspecialchars($s['student_id']) ?></td>
            <td><?= htmlspecialchars($s['student_status']) ?></td>
            <td><?= htmlspecialchars(date("Y-m-d H:i", strtotime($s['archived_date']))) ?></td>
            <td>
              <button onclick="viewStudent(this)">View</button>
              <form method="POST" style="display:inline;">
                <input type="hidden" name="recover_student_id" value="<?= htmlspecialchars($s['student_id']) ?>">
                
              </form>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div id="viewModal" class="modal">
  <div class="modal-content" style="max-width:700px;">
    <span class="close" onclick="closeModal('viewModal')">&times;</span>
    <div id="viewStudentDetails"></div>
  </div>
</div>

<script>
// === Search Bar ===
const searchInput = document.getElementById("searchInput");
const suggestionsBox = document.getElementById("suggestionsBox");
const rows = document.querySelectorAll("#studentsTable tbody tr");

searchInput.addEventListener("input", () => {
  const filter = searchInput.value.toLowerCase();
  let matches = [];
  rows.forEach(r => {
    const text = r.innerText.toLowerCase();
    const show = text.includes(filter);
    r.style.display = show ? "" : "none";
    if (show && filter) matches.push(r.cells[0].innerText);
  });
  suggestionsBox.innerHTML = "";
  if (filter && matches.length > 0) {
    suggestionsBox.style.display = "block";
    [...new Set(matches)].slice(0, 6).forEach(name => {
      const div = document.createElement("div");
      div.innerHTML = name.replace(new RegExp(`(${filter})`, "gi"), "<b>$1</b>");
      div.onclick = () => {
        searchInput.value = name;
        suggestionsBox.style.display = "none";
        rows.forEach(r => r.style.display = r.innerText.toLowerCase().includes(name.toLowerCase()) ? "" : "none");
      };
      suggestionsBox.appendChild(div);
    });
  } else suggestionsBox.style.display = "none";
});
document.addEventListener("click", e => {
  if (!suggestionsBox.contains(e.target) && e.target !== searchInput)
    suggestionsBox.style.display = "none";
});

// === Modal Logic ===
function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = "none";
}

function viewStudent(btn) {
  const s = JSON.parse(btn.closest("tr").dataset.student);

  const photo = s.photo_path
    ? `<img src="../components/img/ids/${s.photo_path}" style="width:140px;height:160px;border-radius:8px;border:1px solid #000;object-fit:cover;">`
    : `<div style="width:140px;height:160px;border:1px dashed #999;display:flex;align-items:center;justify-content:center;color:#777;">No Photo</div>`;

  // format archived files
  let filesHtml = '<p style="color:#777;">No archived files found.</p>';
  if (s.archived_files) {
    const fileList = s.archived_files.split('||').filter(Boolean);
    if (fileList.length > 0) {
      filesHtml = '<ul style="list-style:none;padding-left:0;">' + fileList.map(f => {
        const [type, path] = f.split('|');
        return `<li>📄 <b>${type}</b> — <a href="../${path}" target="_blank">View File</a></li>`;
      }).join('') + '</ul>';
    }
  }

  const content = `
    <h2 style="text-align:center;color:#1e3a8a;">Archived Student Information</h2>
    <div style="display:flex;gap:25px;align-items:flex-start;justify-content:center;flex-wrap:wrap;">
      <div style="flex:0 0 160px;text-align:center;">
        <h4 style="margin-bottom:8px;">Photo</h4>
        ${photo}
      </div>
      <div style="flex:1;min-width:260px;">
        <p><b>Student ID:</b> ${s.student_id}</p>
        <p><b>Name:</b> ${s.first_name} ${s.last_name}</p>
        <p><b>Birthdate:</b> ${s.birthdate || 'N/A'}</p>
        <p><b>Program:</b> ${s.program}</p>
        <p><b>Year Level:</b> ${s.year_level}</p>
        <p><b>Section:</b> ${s.section}</p>
        <p><b>Status:</b> ${s.student_status}</p>
        <p><b>Date Archived:</b> ${s.archived_date}</p>
      </div>
    </div>
    <hr>
    <h3>👨‍👩‍👧 Guardian Information</h3>
    <p><b>Name:</b> ${s.guardian_name || 'N/A'}</p>
    <p><b>Contact:</b> ${s.guardian_contact || 'N/A'}</p>
    <p><b>Address:</b> ${s.guardian_address || 'N/A'}</p>
    <hr>
    <h3>🎓 Academic Background</h3>
    <p><b>Primary:</b> ${s.primary_school || 'N/A'} (${s.primary_year || ''})</p>
    <p><b>Secondary:</b> ${s.secondary_school || 'N/A'} (${s.secondary_year || ''})</p>
    <p><b>Tertiary:</b> ${s.tertiary_school || 'N/A'} (${s.tertiary_year || ''})</p>
    <hr>
    <h3>📂 Archived Files</h3>
    ${filesHtml}
  `;

  document.getElementById("viewStudentDetails").innerHTML = content;
  document.getElementById("viewModal").style.display = "flex";
}
</script>
</body>
</html>
