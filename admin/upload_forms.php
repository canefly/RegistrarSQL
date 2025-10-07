<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
include "AdminSidenav.php";

if ($_SESSION['role_id'] != 1) {
  header("Location: ../index.php");
  exit();
}

$forms_dir = __DIR__ . "/../student/forms/";
$upload_message = "";

// ✅ Upload
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

// ✅ Delete
if (isset($_GET['delete'])) {
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ------------------ Body / Background ------------------ */
global css for offset effect

/* Default layout */
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}

/* Sidebar offset container (shared for content pages) */
.content, 
.container {
  flex: 1;
  margin-left: 240px; /* same width as sidebar */
  padding: 20px 40px;
  transition: margin-left 0.3s ease;
  box-sizing: border-box;
}

/* Adjust when sidebar is collapsed */
.sidebar.collapsed ~ .content,
.sidebar.collapsed ~ .container {
  margin-left: 70px; /* collapsed width */
}

/* Toggle button positioning */
.toggle-btn {
  position: fixed;
  top: 20px;
  left: 250px;
  background: #0056d2;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 50%;
  cursor: pointer;
  transition: left 0.3s ease, transform 0.3s ease;
  z-index: 1100;
}

.sidebar.collapsed + .toggle-btn {
  left: 80px;
}

.sidebar.collapsed + .toggle-btn i {
  transform: rotate(180deg);
}

/* Responsive fix */
@media (max-width: 768px) {
  .content, 
  .container {
    margin-left: 0;
    padding: 20px;
  }
  .toggle-btn {
    left: 20px !important; /* stays accessible */
  }
}


/* ------------------ Headings ------------------ */
h1 { font-size: 32px; margin-bottom: 10px; color:#222; }
p { font-size: 18px; color: #555; }

/* ------------------ Search ------------------ */
.search-bar {
  position: relative;
  width: 100%;
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

/* ------------------ Upload Section ------------------ */
.upload-section {
  background: linear-gradient(135deg, #f9fbff 0%, #eef3ff 100%);
  border: 1px solid #d8e3ff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 3px 10px rgba(0, 86, 210, 0.05);
  margin-bottom: 25px;
  transition: 0.3s;
}
.upload-section:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 86, 210, 0.12);
  border-color: #0056d2;
}
.upload-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 12px;
}
.upload-header i { color: #0056d2; font-size: 18px; }
.upload-header h4 { font-size: 16px; color: #003b99; margin: 0; }
.upload-form { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }
.upload-form input[type=file] { display: none; }
.file-label {
  background: #0056d2; color: white;
  padding: 10px 18px; border-radius: 8px;
  cursor: pointer; font-size: 14px;
  display: flex; align-items: center; gap: 8px;
  transition: background 0.3s ease;
}
.file-label:hover { background: #003b99; }
.file-name {
  font-size: 13px; color: #bbb; padding: 0 6px; font-style: italic;
}
.upload-btn {
  background: #00a86b; color: white; border: none;
  padding: 10px 20px; border-radius: 8px; cursor: pointer;
  font-weight: 500; display: flex; align-items: center; gap: 6px;
  transition: background 0.3s ease, transform 0.2s;
}
.upload-btn:hover { background: #008a59; transform: translateY(-1px); }

/* ------------------ Table (Forms Table) ------------------ */
.forms-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: #ffffff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  margin-top: 15px;
  font-family: 'Outfit', sans-serif;
  font-size: 15px;
}
.forms-table thead {
  background: #004aad;
  color: #ffffff;
}
.forms-table th {
  padding: 14px 16px;
  text-align: center;
  font-weight: 600;
  letter-spacing: 0.3px;
}
.forms-table td {
  padding: 13px 15px;
  text-align: center;
  border-bottom: 1px solid #eee;
}
.forms-table tbody tr:nth-child(odd) { background-color: #ffffff; }
.forms-table tbody tr:nth-child(even) { background-color: #f9fafb; }
.forms-table tbody tr:hover { background: #f1f5ff; transition: background 0.25s ease; }

/* Buttons */
.forms-table a.view, .forms-table button.delete {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 13px;
  text-decoration: none;
  color: white;
  transition: background 0.3s ease;
}
.forms-table a.view {
  background: #004aad;
}
.forms-table a.view:hover {
  background: #003377;
}
.forms-table button.delete {
  background: #dc3545;
}
.forms-table button.delete:hover {
  background: #c82333;
}

/* Responsive */
@media (max-width:768px){
  .forms-table th, .forms-table td { padding: 10px 8px; font-size: 13px; }
  .forms-table td:last-child {
    display: flex; flex-direction: column; gap: 6px;
  }
  .forms-table td:last-child a,
  .forms-table td:last-child button {
    width: 100%; text-align: center;
  }
}
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
            <i class="<?= $icon ?>"></i><?= htmlspecialchars($file) ?>
          </td>
          <td><?= round(filesize($forms_dir . $file)/1024,2) ?></td>
          <td>
            <a href="/RegistrarSQL/student/forms/<?= rawurlencode($file) ?>" target="_blank" class="view"><i class="fa-regular fa-eye"></i> View</a>
            <button class="delete" onclick="confirmDelete('<?= htmlspecialchars($file) ?>')"><i class="fa-solid fa-trash"></i> Delete</button>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr id="noResultsRow"><td colspan="3">No forms uploaded yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);">
  <div class="modal-content" style="background:#fff;margin:10% auto;border-radius:10px;padding:20px;width:80%;max-width:450px;text-align:center;">
    <h3><i class="fa-solid fa-triangle-exclamation" style="color:#e00;"></i> Confirm Deletion</h3>
    <p id="deleteMsg"></p>
    <div style="margin-top:15px;">
      <button onclick="closeModal()" style="padding:6px 12px;border:none;border-radius:6px;background:#6c757d;color:#fff;">Cancel</button>
      <a id="confirmLink" href="#" style="padding:6px 12px;border:none;border-radius:6px;background:#dc3545;color:#fff;text-decoration:none;">Delete</a>
    </div>
  </div>
</div>

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

// ✅ Delete Modal
const modal=document.getElementById('deleteModal');
const msg=document.getElementById('deleteMsg');
const link=document.getElementById('confirmLink');
function confirmDelete(name){
  msg.innerHTML=`Are you sure you want to delete <b>${name}</b>?`;
  link.href='?delete='+encodeURIComponent(name);
  modal.style.display='block';
}
function closeModal(){modal.style.display='none';}
window.onclick=(e)=>{if(e.target==modal)closeModal();}
</script>
</body>
</html>
