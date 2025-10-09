<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
include "AdminSidenav.php";
requireRole("Admin");

if ($_SESSION['role_id'] != 1) {
  header("Location: ../index.php");
  exit();
}

$forms_dir = __DIR__ . "/../student/forms/";
$upload_message = "";

// ✅ Upload handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['form_file'])) {
  $file = $_FILES['form_file'];
  $filename = basename($file['name']);
  $target_path = $forms_dir . $filename;
  $allowed_types = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
  ];

  if ($file['error'] === 0) {
    if (in_array($file['type'], $allowed_types)) {
      if (move_uploaded_file($file['tmp_name'], $target_path)) {
        $upload_message = "<div class='alert alert-success'><i class='fa-solid fa-circle-check me-1'></i> File uploaded successfully!</div>";
      } else {
        $upload_message = "<div class='alert alert-warning'><i class='fa-solid fa-triangle-exclamation me-1'></i> Failed to move file.</div>";
      }
    } else {
      $upload_message = "<div class='alert alert-danger'><i class='fa-solid fa-ban me-1'></i> Invalid file type. Only PDF, DOC, and DOCX allowed.</div>";
    }
  } else {
    $upload_message = "<div class='alert alert-warning'><i class='fa-solid fa-triangle-exclamation me-1'></i> Upload error occurred.</div>";
  }
}

// ✅ Delete handler
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
  $delete_file = basename($_GET['delete']);
  $file_path = $forms_dir . $delete_file;

  if (file_exists($file_path)) {
    unlink($file_path);
    $upload_message = "<div class='alert alert-danger'><i class='fa-solid fa-trash-can me-1'></i> File deleted successfully!</div>";
  } else {
    $upload_message = "<div class='alert alert-warning'><i class='fa-solid fa-triangle-exclamation me-1'></i> File not found.</div>";
  }
}

$files = array_diff(scandir($forms_dir), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Student Forms</title>
<link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
<link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;700&display=swap" rel="stylesheet">

<style>
/* ===== SIDEBAR OFFSET RESPONSIVE FIX ===== */
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}

/* main layout container */
.container {
  flex: 1;
  margin-left: 240px;
  padding: 20px 30px 40px 30px; /* reduced horizontal gap */
  transition: margin-left 0.3s ease;
  box-sizing: border-box;
  width: 100%;
  max-width: none; /* remove bootstrap restriction */
}


/* when sidebar collapsed */
.sidebar.collapsed ~ .container {
  margin-left: 70px;
}

/* responsive fix for mobile */
@media (max-width: 768px) {
  .container {
    margin-left: 0;
    padding: 20px;
  }
}

/* ===== HEADER ===== */
h1 {
  font-size: 30px;
  font-weight: 700;
  color: #000000ff;
  margin-bottom: 6px;
}
p {
  color: #555;
  margin-bottom: 20px;
  font-size: 16px;
}

/* ===== SEARCH BAR ===== */
.search-bar {
  max-width: 400px;
  margin-bottom: 20px;
}
#searchInput {
  padding: 12px 18px;
  width: 100%;
  border: 1px solid #d1d5db;
  border-radius: 25px;
  font-size: 15px;
  background: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  transition: all 0.2s ease;
}
#searchInput:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 6px rgba(59,130,246,0.4);
  outline: none;
}

/* ===== UPLOAD BOX ===== */
.upload-section {
  background: linear-gradient(135deg, #f9fbff 0%, #eef3ff 100%);
  border: 1px solid #d8e3ff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 3px 10px rgba(0, 86, 210, 0.05);
  margin-bottom: 25px;
  transition: 0.3s;
}
.upload-header {
  display: flex; align-items: center; gap: 8px; margin-bottom: 12px;
}
.upload-header i { color: #004aad; font-size: 18px; }
.upload-header h4 { font-size: 16px; color: #004aad; margin: 0; }
.upload-form { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }
.upload-form input[type=file] { display: none; }
.file-label {
  background: #004aad; color: white;
  padding: 10px 18px; border-radius: 8px;
  cursor: pointer; font-size: 14px;
  display: flex; align-items: center; gap: 8px;
}
.file-label:hover { background: #00348d; }
.upload-btn {
  background: #00a86b;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 6px;
}
.upload-btn:hover { background: #008a59; }
.file-name {
  font-size: 13px; color: #999; padding: 0 6px; font-style: italic;
}

/* ===== TABLE STYLING ===== */
.forms-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: #ffffff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  font-family: 'Outfit', sans-serif;
  font-size: 15px;
}
.forms-table thead {
  background: #004aad;
  color: #ffffff;
}
.forms-table th, .forms-table td {
  padding: 13px 15px;
  text-align: center;
  border-bottom: 1px solid #eee;
  white-space: nowrap;
}
.forms-table td.text-start { text-align: left; }
.forms-table tbody tr:hover {
  background: #f1f5ff;
  transition: background 0.25s ease;
}

/* ===== BUTTONS ===== */
.forms-table a.view, .forms-table button.delete {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  text-decoration: none;
  color: #fff;
  transition: background 0.3s ease;
}
.forms-table a.view { background: #004aad; }
.forms-table a.view:hover { background: #003377; }
.forms-table button.delete { background: #dc3545; }
.forms-table button.delete:hover { background: #b72432; }
</style>
</head>
<body>

<div class="container">
  <h1>Student Forms</h1>
  <p>Below is the list of student forms available for download and management.</p>

  <?= $upload_message ?>

  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search form by filename...">
  </div>

  <div class="upload-section">
    <div class="upload-header">
      <i class="fas fa-cloud-upload-alt"></i><h4>Upload New Document</h4>
    </div>
    <form method="POST" enctype="multipart/form-data" class="upload-form">
      <label class="file-label">
        <i class="fas fa-file-upload"></i> Choose File
        <input type="file" name="form_file" required onchange="this.parentNode.querySelector('.file-name').textContent=this.files[0]?this.files[0].name:'No file chosen';">
        <span class="file-name">No file chosen</span>
      </label>
      <button type="submit" class="upload-btn"><i class="fas fa-upload"></i> Upload</button>
    </form>
  </div>

  <table class="forms-table" id="formsTable">
    <thead>
      <tr>
        <th>File Name</th>
        <th>Size (KB)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($files)): foreach ($files as $file): ?>
        <tr>
          <td class="text-start">
            <?php
              $ext = pathinfo($file, PATHINFO_EXTENSION);
              $icon = 'fa-regular fa-file';
              if ($ext==='pdf') $icon='fa-regular fa-file-pdf text-danger';
              elseif(in_array($ext,['doc','docx'])) $icon='fa-regular fa-file-word text-primary';
            ?>
            <i class="<?= $icon ?>"></i> <?= htmlspecialchars($file) ?>
          </td>
          <td><?= round(filesize($forms_dir . $file)/1024,2) ?></td>
          <td>
            <a href="/RegistrarSQL/student/forms/<?= rawurlencode($file) ?>" target="_blank" class="view"><i class="fa-regular fa-eye"></i> View</a>
            <button class="delete" onclick="openDeleteModal('<?= htmlspecialchars($file) ?>')"><i class="fa-solid fa-trash"></i> Delete</button>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr id="noResultsRow"><td colspan="3">No forms uploaded yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">
          <i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm File Deletion
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="fw-semibold fs-6">You are about to permanently delete the file:</p>
        <p id="deleteFileName" class="text-danger fw-bold fs-5 mb-2"></p>
        <p class="text-muted small">This action <strong>cannot be undone</strong>.</p>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa-solid fa-xmark me-1"></i> Cancel
        </button>
        <a id="confirmDeleteLink" href="#" class="btn btn-danger">
          <i class="fa-solid fa-trash-can me-1"></i> Confirm Delete
        </a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ✅ Search Filter
const input=document.getElementById('searchInput');
input.addEventListener('keyup',()=>{
  const filter=input.value.toLowerCase();
  let found=false;
  document.querySelectorAll('#formsTable tbody tr').forEach(tr=>{
    const txt=tr.cells[0].innerText.toLowerCase();
    const visible=txt.includes(filter);
    tr.style.display=visible?'':'none';
    if(visible) found=true;
  });
  document.getElementById('noResultsRow').style.display=found?'none':'table-row';
});

// ✅ Bootstrap Delete Modal
let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
const deleteFileName = document.getElementById('deleteFileName');
const confirmLink = document.getElementById('confirmDeleteLink');

function openDeleteModal(filename) {
  deleteFileName.textContent = filename;
  confirmLink.href = '?delete=' + encodeURIComponent(filename);
  deleteModal.show();
}
</script>
</body>
</html>
