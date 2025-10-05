<?php
require_once __DIR__ . '/../Database/session-checker.php';
require_once __DIR__ . '/../Database/connection.php';

$sql = "
SELECT l.syslog_id, l.level, l.message, l.origin, l.timestamp, u.username, r.name AS role
FROM system_logs l
LEFT JOIN users u ON l.user_id = u.user_id
LEFT JOIN roles r ON u.role_id = r.role_id
ORDER BY l.timestamp DESC
LIMIT 50
";
$result = $conn->query($sql);
$logs = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Recent Activity Logs</title>
<link rel="stylesheet" href="../components/css/Admin.css">
<style>
body {
  font-family: 'Outfit', sans-serif;
  background: #f3f4f6;
  margin: 0;
  overflow-x: hidden;
}

.container {
  margin-left: 240px;
  padding: 40px 60px;
  width: calc(100% - 240px);
  min-height: 100vh;
  box-sizing: border-box;
  transition: margin-left 0.3s ease, width 0.3s ease;
}

.sidebar.collapsed ~ .container {
  margin-left: 70px;
  width: calc(100% - 70px);
}

h1 {
  color: #1e3a8a;
  margin-bottom: 8px;
  font-size: 2rem;
}

p {
  margin-top: 0;
  color: #475569;
  font-size: 15px;
}

/* Search Bar */
.search-bar {
  width: 100%;
  max-width: 500px;
  margin: 25px 0 30px;
  position: relative;
}

.search-bar input {
  width: 100%;
  padding: 14px 45px 14px 18px;
  border: 1px solid #cbd5e1;
  border-radius: 30px;
  font-size: 16px;
  background: white;
  box-shadow: 0 3px 6px rgba(0,0,0,0.05);
  transition: all 0.2s ease;
}

.search-bar input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 8px rgba(59,130,246,0.4);
  outline: none;
}

.search-bar i {
  position: absolute;
  right: 18px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 18px;
}

/* Table */
.log-table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

th {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: white;
  text-align: left;
  padding: 14px 18px;
  font-weight: 600;
  letter-spacing: 0.3px;
  position: sticky;
  top: 0;
  z-index: 2;
}

td {
  padding: 14px 18px;
  border-bottom: 1px solid #f1f5f9;
  color: #334155;
  font-size: 15px;
}

tr:hover {
  background: #f9fafb;
}

.level-INFO { color: #16a34a; font-weight: 600; }
.level-WARNING { color: #f59e0b; font-weight: 600; }
.level-ERROR { color: #dc2626; font-weight: 600; }

/* Responsive */
@media (max-width: 768px) {
  .container {
    margin-left: 0;
    width: 100%;
    padding: 20px;
  }
  th, td { font-size: 13px; }
}
</style>
</head>
<body>
<?php include 'AdminSidenav.php'; ?>
<div class="container">
  <h1>Recent Activity Logs</h1>
  <p>System events and user actions are listed below.</p>

  <!-- Search Bar -->
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search logs...">
    <i class="fa fa-search"></i>
  </div>

  <!-- Logs Table -->
  <table class="log-table" id="logTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Level</th>
        <th>Message</th>
        <th>Origin</th>
        <th>User</th>
        <th>Role</th>
        <th>Timestamp</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($logs as $log): ?>
        <tr>
          <td><?= $log['syslog_id'] ?></td>
          <td class="level-<?= htmlspecialchars($log['level']) ?>"><?= htmlspecialchars($log['level']) ?></td>
          <td><?= htmlspecialchars($log['message']) ?></td>
          <td><?= htmlspecialchars($log['origin']) ?></td>
          <td><?= htmlspecialchars($log['username'] ?: '—') ?></td>
          <td><?= htmlspecialchars($log['role'] ?: '—') ?></td>
          <td><?= htmlspecialchars($log['timestamp']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- FontAwesome for search icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Live Search Script -->
<script>
const searchInput = document.getElementById("searchInput");
const table = document.getElementById("logTable");
const rows = table.getElementsByTagName("tr");

searchInput.addEventListener("keyup", function() {
  const filter = this.value.toLowerCase();
  for (let i = 1; i < rows.length; i++) {
    const row = rows[i];
    const cells = row.getElementsByTagName("td");
    let match = false;
    for (let j = 0; j < cells.length; j++) {
      const cell = cells[j];
      if (cell.textContent.toLowerCase().includes(filter)) {
        match = true;
        break;
      }
    }
    row.style.display = match ? "" : "none";
  }
});
</script>
</body>
</html>
