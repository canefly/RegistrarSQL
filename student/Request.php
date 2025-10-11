<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
requireRole("Student");

// Ensure student is logged in
$uid = $_SESSION['user_id'] ?? null;
if (!$uid) {
    header("Location: ../index.php"); // back to login if no session
    exit();
}

// Get the matching student_id from students table
$stmt = $conn->prepare("SELECT student_id FROM students WHERE user_id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
$studentRow = $result->fetch_assoc();

if (!$studentRow) {
    die("No student profile found for this account.");
}
$student_id = $studentRow['student_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['document_type'])) {
    $document_type = $conn->real_escape_string($_POST['document_type']);
    $notes = $conn->real_escape_string($_POST['notes'] ?? '');
    $request_date = date('Y-m-d');

    $sql = "INSERT INTO document_requests (student_id, document_type, notes, request_date, status) 
            VALUES ('$student_id', '$document_type', '$notes', '$request_date', 'Pending')";
    if ($conn->query($sql)) {
        echo "<script>window.onload = () => showToast('✅ Request Submitted Successfully!');</script>";
    } else {
        echo "<script>window.onload = () => showToast('❌ Failed to submit request.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
  <link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Outfit', sans-serif;
      background: #f9f9f9;
      color: #333;
      display: flex;
      min-height: 100vh;
    }

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


    h1 { font-size: 26px; font-weight: 700; margin-bottom: 10px; }
    p { color: #555; margin-bottom: 24px; }

    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 24px 18px;
      text-align: center;
      transition: .3s;
    }
    .card:hover { transform: translateY(-5px); }
    .card i { font-size: 40px; color: #004aad; margin-bottom: 12px; }
    .card h3 { margin: 10px 0; font-size: 18px; }
    .card p { font-size: 13px; color: #666; margin-bottom: 15px; }
    .card button {
      padding: 10px 18px;
      border: none; border-radius: 8px;
      background: #004aad; color: #fff;
      font-weight: 600; cursor: pointer; transition: .2s;
    }
    .card button:hover { background: #003377; }

    /* Modal */
    .modal {
      display: none; position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      justify-content: center; align-items: center;
      z-index: 2000;
    }
    .modal-content {
      background: #fff;
      padding: 30px 25px;
      border-radius: 14px;
      width: 420px;
      max-width: 90%;
      margin: auto;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
      position: relative;
      animation: zoomIn 0.3s ease;
      text-align: left;
    }
    @keyframes zoomIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .close {
      position: absolute;
      top: 12px;
      right: 14px;
      font-size: 22px;
      cursor: pointer;
      color: #777;
      transition: 0.2s;
    }
    .close:hover { color: #e53e3e; }

    .modal-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 18px;
    }
    .modal-header i {
      font-size: 22px;
      color: #004aad;
    }
    .modal-header h2 {
      margin: 0;
      font-size: 18px;
      color: #004aad;
      font-weight: 700;
    }

    /* Form elements */
    .modal-content label {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 6px;
      display: block;
    }
    .modal-content textarea {
      width: 100%;
      box-sizing: border-box;
      margin-top: 5px;
      margin-bottom: 15px;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 14px;
      font-family: 'Outfit', sans-serif;
      resize: vertical;
      transition: border 0.2s, box-shadow 0.2s;
    }
    .modal-content textarea:focus {
      border-color: #004aad;
      box-shadow: 0 0 5px rgba(0,74,173,0.3);
      outline: none;
    }

    /* Buttons */
    .modal-actions {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
    }
    .cancel-btn, .submit-btn {
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.2s;
    }
    .cancel-btn {
      background: #eee;
      color: #555;
    }
    .cancel-btn:hover { background: #ddd; }
    .submit-btn {
      background: #004aad;
      color: #fff;
    }
    .submit-btn:hover { background: #003377; }

    /* Toast */
    .toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background: #004aad;
      color: #fff;
      text-align: center;
      border-radius: 8px;
      padding: 14px;
      position: fixed;
      z-index: 3000;
      left: 50%;
      bottom: 30px;
      font-size: 15px;
      font-weight: 600;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      opacity: 0;
      transition: opacity 0.5s, bottom 0.5s;
    }
    .toast.show {
      visibility: visible;
      opacity: 1;
      bottom: 50px;
    }
  </style>
</head>
<body>

<?php include 'StudentSidenav.php'; ?>

<div class="container">
  <h1>Request Documents</h1>
  <p>Select the type of document you want to request.</p>

  <div class="cards">
    <div class="card">
      <i class="fa-solid fa-id-card"></i>
      <h3>ID Replacement</h3>
      <p>Bring your Affidavit of Loss.</p>
      <button onclick="openModal('ID Replacement')">Request</button>
    </div>
    <div class="card">
      <i class="fa-solid fa-receipt"></i>
      <h3>Receipt Records</h3>
      <p>Enter OR number and remarks.</p>
      <button onclick="openModal('Receipt Records')">Request</button>
    </div>
    <div class="card">
      <i class="fa-solid fa-certificate"></i>
      <h3>Certificate of Enrollment</h3>
      <p>For official enrollment verification.</p>
      <button onclick="openModal('Certificate of Enrollment')">Request</button>
    </div>
    <div class="card">
      <i class="fa-solid fa-file"></i>
      <h3>Other Documents</h3>
      <p>TOR, Good Moral, Grades, etc.</p>
      <button onclick="openModal('Other Documents')">Request</button>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal" id="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-header">
      <i class="fa-solid fa-file-pen"></i>
      <h2 id="modalTitle"></h2>
    </div>
    <form method="POST">
      <input type="hidden" name="document_type" id="documentType">
      <label for="notes">Additional Notes</label>
      <textarea name="notes" id="notes" rows="4" placeholder="Write your remarks here..."></textarea>
      <div class="modal-actions">
        <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
        <button type="submit" class="submit-btn">Submit Request</button>
      </div>
    </form>
  </div>
</div>

<!-- Toast -->
<div id="toast" class="toast">✅ Request Submitted Successfully!</div>

<script>
function openModal(docType) {
  document.getElementById("modal").style.display = "flex";
  document.getElementById("modalTitle").innerText = docType;
  document.getElementById("documentType").value = docType;
}
function closeModal() {
  document.getElementById("modal").style.display = "none";
}
window.onclick = function(e) {
  if (e.target == document.getElementById("modal")) closeModal();
}

// Toast function
function showToast(msg) {
  let toast = document.getElementById("toast");
  toast.innerText = msg;
  toast.classList.add("show");
  setTimeout(() => {
    toast.classList.remove("show");
  }, 3000);
}
</script>
</body>
</html>
