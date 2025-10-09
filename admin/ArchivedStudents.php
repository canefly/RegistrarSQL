<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/functions.php";

// Fetch archived students
$res = $conn->query("
  SELECT 
    archive_id,
    student_id,
    first_name,
    last_name,
    program,
    year_level,
    section,
    student_status,
    contact_no,
    address,
    birthdate,
    photo_path,
    archived_date
  FROM archived_students
  ORDER BY archived_date DESC, last_name ASC, first_name ASC
");


$arch = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Archived Students</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../components/img/bcpp.png" type="image/png">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../components/css/ArchivedStudents.css">
</head>
<body>

<?php include 'AdminSidenav.php'; ?>

<div class="container">
  <h1>Archived Students</h1>
  <p>For future reference — these records are snapshots at the time of student status change.</p>

  <!-- 🧭 Search Bar -->
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search student by name, ID, or program..." autocomplete="off">
    <div id="suggestionsBox" class="suggestions" style="display:none;"></div>
  </div>

  <table class="requests-table" id="archTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Student ID</th>
        <th>Program</th>
        <th>Year</th>
        <th>Section</th>
        <th>Status</th>
        <th>Date Archived</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($arch) === 0): ?>
        <tr><td colspan="8">No archived student records found.</td></tr>
      <?php else: foreach($arch as $a): ?>
        <tr data-student='<?= json_encode($a, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
          <td><?= htmlspecialchars($a['last_name'].", ".$a['first_name']) ?></td>
          <td><?= htmlspecialchars($a['student_id']) ?></td>
          <td><?= htmlspecialchars($a['program']) ?></td>
          <td><?= htmlspecialchars($a['year_level']) ?></td>
          <td><?= htmlspecialchars($a['section']) ?></td>
          <td>
            <?php if ($a['student_status'] === 'Graduated'): ?>
              <span class="status Approved">Graduated</span>
            <?php else: ?>
              <span class="status Declined">Dropped</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($a['archived_date']))) ?></td>
          <td><button class="view-btn" onclick="viewStudent(this)">View</button></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>

<!-- 🔹 Modal -->
<div id="viewModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <div id="viewStudentDetails"></div>
  </div>
</div>

<script>
// === Search Logic with Suggestions ===
const searchInput = document.getElementById('searchInput');
const tableRows = document.querySelectorAll('#archTable tbody tr');
const suggestionsBox = document.getElementById('suggestionsBox');

searchInput.addEventListener('input', function () {
  const filter = this.value.toLowerCase().trim();
  let matches = [];

  tableRows.forEach(row => {
    const text = row.innerText.toLowerCase();
    const match = text.includes(filter);
    row.style.display = match ? '' : 'none';
    if (match && filter) {
      const nameCell = row.cells[0]?.innerText || '';
      matches.push(nameCell);
    }
  });

  suggestionsBox.innerHTML = '';
  if (filter && matches.length > 0) {
    suggestionsBox.style.display = 'block';
    [...new Set(matches)].slice(0, 6).forEach(name => {
      const div = document.createElement('div');
      div.innerHTML = name.replace(new RegExp(`(${filter})`, 'gi'), '<b>$1</b>');
      div.addEventListener('click', () => {
        searchInput.value = name;
        suggestionsBox.style.display = 'none';
        tableRows.forEach(row => {
          const text = row.innerText.toLowerCase();
          row.style.display = text.includes(name.toLowerCase()) ? '' : 'none';
        });
      });
      suggestionsBox.appendChild(div);
    });
  } else {
    suggestionsBox.style.display = 'none';
  }
});

document.addEventListener('click', e => {
  if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
    suggestionsBox.style.display = 'none';
  }
});

// === Modal Logic ===
function viewStudent(btn) {
  const row = btn.closest("tr");
  const s = JSON.parse(row.dataset.student);

  const photo = s.photo_path
    ? `<img src="../components/img/ids/${s.photo_path}" alt="Student Photo" style="width:140px;height:160px;border:1px solid #000;border-radius:8px;object-fit:cover;">`
    : `<div style="width:140px;height:160px;border:1px dashed #999;display:flex;align-items:center;justify-content:center;border-radius:8px;color:#777;font-style:italic;">No Photo</div>`;

  const content = `
    <h2 style="text-align:center;margin-bottom:20px;color:#1e3a8a;">Archived Student Information</h2>
    <div style="display:flex;gap:25px;align-items:flex-start;justify-content:center;flex-wrap:wrap;">
      <div style="flex:0 0 160px;text-align:center;">
        <h4 style="margin-bottom:8px;">Student Photo</h4>
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
  `;
  document.getElementById("viewStudentDetails").innerHTML = content;
  document.getElementById("viewModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("viewModal").style.display = "none";
}
</script>
</body>
</html>
