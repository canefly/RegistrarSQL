<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
requireRole("Admin");

// 🔹 Delete archived request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM archived_requests WHERE request_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('Archived request deleted successfully!'); window.location='Archive.php';</script>";
    exit;
}

// 🔹 Fetch all archived requests with student info
$sql = "SELECT a.request_id, a.student_id, a.document_type, a.request_date, a.status, a.release_date,
               s.first_name, s.last_name
        FROM archived_requests a
        LEFT JOIN students s ON a.student_id = s.student_id
        ORDER BY a.request_date DESC";
$result = $conn->query($sql);
$archives = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Archived Requests</title>
<link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../components/css/StaffRequest.css">
<style>
/* === legendary search bar === */
.search-bar {
  position: relative;
  width: 100%;
  max-width: 380px;
  margin-bottom: 20px;
}

#searchInput {
  width: 100%;
  padding: 12px 18px;
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

/* === suggestion dropdown === */
.suggestions {
  position: absolute;
  top: 105%;
  left: 0;
  width: 100%;
  background: #fff;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  max-height: 220px;
  overflow-y: auto;
  z-index: 999;
  display: none;
}

.suggestions div {
  padding: 10px 14px;
  font-size: 14px;
  color: #333;
  cursor: pointer;
  transition: background 0.2s;
}

.suggestions div:hover {
  background: #f1f5ff;
  color: #0056d2;
}
</style>
</head>
<body>

<?php include 'AdminSidenav.php'; ?>

<div class="container">
  <h1> Archived Requests</h1>
  <p>All processed student document requests are stored here for record-keeping and reference.</p>

  <!-- 🔍 Search Bar -->
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search by student name, ID, or document type..." autocomplete="off">
    <div id="suggestionsBox" class="suggestions"></div>
  </div>

  <table class="requests-table" id="archiveTable">
    <thead>
      <tr>
        <th>Request ID</th>
        <th>Student Name</th>
        <th>Document Type</th>
        <th>Request Date</th>
        <th>Status</th>
        <th>Release Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($archives): ?>
        <?php foreach ($archives as $row): ?>
        <tr>
          <td><?= $row['request_id'] ?></td>
          <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
          <td><?= htmlspecialchars($row['document_type']) ?></td>
          <td><?= $row['request_date'] ?></td>
          <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
          <td><?= $row['release_date'] ? $row['release_date'] : '-' ?></td>
          <td>
            <a href="print_request.php?id=<?= $row['request_id'] ?>" target="_blank">
              <button class="print"><i class="fa-solid fa-print"></i></button>
            </a>
            <a href="?delete=<?= $row['request_id'] ?>" onclick="return confirm('Permanently delete this archived record?');">
              <button class="decline"><i class="fa-solid fa-trash"></i></button>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7">No archived requests found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
// === Smart Search + Suggestions ===
const searchInput = document.getElementById("searchInput");
const tableRows = document.querySelectorAll("#archiveTable tbody tr");
const suggestionsBox = document.getElementById("suggestionsBox");

searchInput.addEventListener("input", function () {
  const filter = this.value.toLowerCase().trim();
  let matches = [];

  tableRows.forEach(row => {
    const text = row.innerText.toLowerCase();
    const match = text.includes(filter);
    row.style.display = match ? "" : "none";
    if (match && filter) {
      const nameCell = row.cells[1]?.innerText || "";
      matches.push(nameCell);
    }
  });

  suggestionsBox.innerHTML = "";
  if (filter && matches.length > 0) {
    suggestionsBox.style.display = "block";
    [...new Set(matches)].slice(0, 6).forEach(name => {
      const div = document.createElement("div");
      div.innerHTML = name.replace(new RegExp(`(${filter})`, "gi"), "<b>$1</b>");
      div.addEventListener("click", () => {
        searchInput.value = name;
        suggestionsBox.style.display = "none";
        tableRows.forEach(row => {
          const text = row.innerText.toLowerCase();
          row.style.display = text.includes(name.toLowerCase()) ? "" : "none";
        });
      });
      suggestionsBox.appendChild(div);
    });
  } else {
    suggestionsBox.style.display = "none";
  }
});

document.addEventListener("click", e => {
  if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
    suggestionsBox.style.display = "none";
  }
});
</script>

</body>
</html>
