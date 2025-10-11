<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/functions.php";
requireRole("Admin");


// 🔹 Handle delete masterlist
if (isset($_GET['delete_masterlist'])) {
    $delete_id = intval($_GET['delete_masterlist']);

    $stmt = $conn->prepare("DELETE FROM masterlist_details WHERE masterlist_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM masterlists WHERE masterlist_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    echo "<script>alert('Masterlist deleted successfully!'); window.location='Masterlist.php';</script>";
    addSystemLog(
    $conn,
    'INFO',
    "Deleted masterlist ID {$delete_id}",
    'staff/Masterlist.php',
    $_SESSION['user_id']
);
    exit;
}

// 🔹 Handle create masterlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_masterlist'])) {
    $term = $_POST['term'];
    $year = $_POST['year'];
    $program = $_POST['program'];
    $section = $_POST['section'];
    $year_level = intval($_POST['year_level']);
    $generated_by = $_SESSION['user_id'];

    // 1️⃣ Create the new masterlist record
    $stmt = $conn->prepare("
        INSERT INTO masterlists (term, year, program, section, year_level, generated_by)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssii", $term, $year, $program, $section, $year_level, $generated_by);
    $stmt->execute();

    // ✅ get the newly created masterlist_id right after execute
    $masterlist_id = $conn->insert_id;

    // 🧾 Log creation of masterlist
    if ($masterlist_id > 0) {
        addSystemLog(
            $conn,
            'INFO',
            "Created new masterlist ({$program} - Year {$year_level}, Section {$section}, Term {$term}, SY {$year})",
            'staff/Masterlist.php',
            $_SESSION['user_id']
        );
    } else {
        die("<script>alert('Error: Failed to create masterlist record.'); window.location='Masterlist.php';</script>");
    }

    // 2️⃣ Fetch all students with matching program, section, and year level
    $students_stmt = $conn->prepare("
        SELECT student_id
        FROM students
        WHERE program = ? AND section = ? AND year_level = ?
    ");
    $students_stmt->bind_param("ssi", $program, $section, $year_level);
    $students_stmt->execute();
    $result = $students_stmt->get_result();

    // 3️⃣ Insert matching students into masterlist_details
    if ($result->num_rows > 0) {
        $insert_stmt = $conn->prepare("
            INSERT INTO masterlist_details (masterlist_id, student_id)
            VALUES (?, ?)
        ");
        while ($row = $result->fetch_assoc()) {
            $insert_stmt->bind_param("is", $masterlist_id, $row['student_id']); // student_id is varchar
            $insert_stmt->execute();
        }

        // 🧾 Log the number of students added
        addSystemLog(
            $conn,
            'INFO',
            "Added {$result->num_rows} students to masterlist ID {$masterlist_id}",
            'staff/Masterlist.php',
            $_SESSION['user_id']
        );

        echo "<script>alert('Masterlist created and students added successfully!'); window.location='Masterlist.php';</script>";
    } else {
        echo "<script>alert('Masterlist created, but no students matched the criteria.'); window.location='Masterlist.php';</script>";
    }

    exit;
}



// 🔹 Fetch masterlists
$sql = "SELECT m.masterlist_id, m.term, m.year, m.program, m.section, m.generation_date, u.username 
        FROM masterlists m
        LEFT JOIN users u ON m.generated_by = u.user_id
        ORDER BY m.generation_date DESC";
$result = $conn->query($sql);
$masterlists = $result->fetch_all(MYSQLI_ASSOC);

// 🔹 Fetch students in a selected masterlist
$students_in_masterlist = [];
$masterlist_info = null;
$viewing_masterlist = null;

if (isset($_GET['view_students'])) {
    $viewing_masterlist = intval($_GET['view_students']);
    $stmt = $conn->prepare("
        SELECT s.student_id, s.first_name, s.last_name, s.program, s.year_level, s.student_status, s.section
        FROM masterlist_details md
        JOIN students s ON md.student_id = s.student_id
        WHERE md.masterlist_id = ?
        ORDER BY s.last_name ASC
    ");
    $stmt->bind_param("i", $viewing_masterlist);
    $stmt->execute();
    $students_in_masterlist = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $info_stmt = $conn->prepare("SELECT term, year, program, section FROM masterlists WHERE masterlist_id = ?");
    $info_stmt->bind_param("i", $viewing_masterlist);
    $info_stmt->execute();
    $masterlist_info = $info_stmt->get_result()->fetch_assoc();
}

// 🔹 Fetch students without section
$students_no_section = [];
$no_section_stmt = $conn->query("SELECT student_id, first_name, last_name, program, year_level FROM students WHERE section IS NULL OR section = '' ORDER BY year_level, last_name");
$students_no_section = $no_section_stmt->fetch_all(MYSQLI_ASSOC);

// 🔹 Handle auto-section
if (isset($_POST['auto_section'])) {
    $stmt = $conn->query("SELECT student_id, year_level FROM students WHERE section IS NULL OR section = '' ORDER BY year_level, student_id");
    $students_to_assign = $stmt->fetch_all(MYSQLI_ASSOC);

    $year_prefix = ['1' => '110', '2' => '210', '3' => '310', '4' => '410'];
    $section_counters = [];

    foreach ($students_to_assign as $student) {
        $year = $student['year_level'];
        $prefix = $year_prefix[$year];

        if (!isset($section_counters[$prefix])) $section_counters[$prefix] = 1;

        $section_code = $prefix . str_pad($section_counters[$prefix], 2, '0', STR_PAD_LEFT);

        // Check if section is full
        $check_stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM students WHERE section = ?");
        $check_stmt->bind_param("s", $section_code);
        $check_stmt->execute();
        $cnt = $check_stmt->get_result()->fetch_assoc()['cnt'];

        if ($cnt >= 50) {
            $section_counters[$prefix]++;
            $section_code = $prefix . str_pad($section_counters[$prefix], 2, '0', STR_PAD_LEFT);
        }

        $update_stmt = $conn->prepare("UPDATE students SET section = ? WHERE student_id = ?");
        $update_stmt->bind_param("si", $section_code, $student['student_id']);
        $update_stmt->execute();

        $section_counters[$prefix]++;
    }

    echo "<script>alert('Auto-section completed successfully!'); window.location='Masterlist.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Masterlist Manager</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
<link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../components/css/masterlists.css">
</head>
<body>

<?php include 'AdminSidenav.php'; ?>

<div class="container">
    <h1> Masterlist Manager</h1>
    <p>Create, view, and print student masterlists per term, year, program, and section.</p>

    <div class="actions">
        <button class="primary" onclick="openCreateModal()">+ Create New Masterlist</button>
    </div>

    <!-- Masterlist Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Term</th><th>Year</th><th>Program</th><th>Section</th><th>Generated By</th><th>Date</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masterlists as $m): ?>
                <tr>
                    <td><?= $m['masterlist_id'] ?></td>
                    <td><?= htmlspecialchars($m['term']) ?></td>
                    <td><?= htmlspecialchars($m['year']) ?></td>
                    <td><?= htmlspecialchars($m['program']) ?></td>
                    <td><?= htmlspecialchars($m['section']) ?></td>
                    <td><?= htmlspecialchars($m['username']) ?></td>
                    <td><?= $m['generation_date'] ?></td>
                    <td>
                        <a href="?view_students=<?= $m['masterlist_id'] ?>"><button> View</button></a>
                        <a href="?view_students=<?= $m['masterlist_id'] ?>#print"><button> Print</button></a>
                        <a href="?delete_masterlist=<?= $m['masterlist_id'] ?>" onclick="return confirm('Are you sure you want to delete this masterlist?');"><button class="danger"> Delete</button></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Masterlist Modal -->
<div id="createModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCreateModal()">&times;</span>
        <h2>Create New Masterlist</h2>
        <form method="POST">
            <label>Term</label>
            <select name="term" required>
                <option value="1st Sem">1st Sem</option>
                <option value="2nd Sem">2nd Sem</option>
                <option value="Summer">Summer</option>
            </select>
            <label>Year</label>
            <input type="text" name="year" value="2025-2026" required>
            <label>Program</label>
            <select name="program" required>
                <option value="BSIT">BSIT</option>
                <option value="BSA">BSA</option>
                <option value="BSBA">BSBA</option>
            </select>
            <label>Year Level</label>
            <select name="year_level" required>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
            </select>
            <label>Section</label>
            <input type="text" name="section" placeholder="e.g. 11001" required>
            <div class="form-actions">
                <button type="button" class="secondary" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="primary" name="create_masterlist">Generate</button>
            </div>
        </form>
    </div>
</div>

<!-- Students Without Section Modal -->
<div id="noSectionModal" class="modal">
  <div class="modal-content wide">
    <span class="close" onclick="closeNoSectionModal()">&times;</span>
    <h2>Students Without Section</h2>
    <form method="POST">
      <table>
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Year Level</th>
            <th>Program</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($students_no_section): ?>
            <?php foreach ($students_no_section as $s): ?>
              <tr>
                <td><?= $s['student_id'] ?></td>
                <td><?= htmlspecialchars($s['first_name'] . " " . $s['last_name']) ?></td>
                <td><?= $s['year_level'] ?></td>
                <td><?= htmlspecialchars($s['program']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4">All students have a section assigned.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="form-actions">
        <button type="submit" class="primary" name="auto_section">Auto-Section</button>
        <button type="button" class="secondary" onclick="closeNoSectionModal()">Close</button>
      </div>
    </form>
  </div>
</div>

<!-- Students in Masterlist Modal -->
<?php if ($viewing_masterlist): ?>
<div id="studentsModal" class="modal" style="display:flex;">
    <div class="modal-content wide">
        <a href="Masterlist.php" class="close">&times;</a>
        <h2>👩‍🎓 Students in Masterlist (ID: <?= $viewing_masterlist ?>)</h2>
        <button onclick="window.print()" class="primary" style="margin-bottom:10px;">🖨 Print Masterlist</button>
        <div id="printArea">
            <div style="display:flex; align-items:center; justify-content:center; margin-bottom:10px; gap:15px;">
                <img src="../components/img/bcpp.png" alt="School Logo" style="width:80px; height:80px;">
                <div style="text-align:center;">
                    <h2 style="margin:0; font-weight:700;">Bestlink College of the Philippines</h2>
                    <p style="margin:0; font-size:14px;">Official Student Masterlist</p>
                </div>
            </div>
            <p style="text-align:center; margin:0 0 15px; font-size:14px;">
                Term: <?= htmlspecialchars($masterlist_info['term']) ?> | 
                School Year: <?= htmlspecialchars($masterlist_info['year']) ?> | 
                Program: <?= htmlspecialchars($masterlist_info['program']) ?> | 
                Section: <?= htmlspecialchars($masterlist_info['section']) ?>
            </p>
            <table border="1" cellspacing="0" cellpadding="7" width="100%" style="border-collapse:collapse; font-size:13px;">
                <thead style="background:#0056d2; color:white;">
                    <tr>
                        <th>Student ID</th><th>Name</th><th>Program</th><th>Year Level</th><th>Section</th><th>Status</th><th>Signature</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students_in_masterlist): ?>
                        <?php foreach ($students_in_masterlist as $i => $s): ?>
                        <tr style="background:<?= $i % 2 === 0 ? '#fff' : '#f5f7fa' ?>;">
                            <td><?= $s['student_id'] ?></td>
                            <td><?= htmlspecialchars($s['first_name'] . " " . $s['last_name']) ?></td>
                            <td><?= htmlspecialchars($s['program']) ?></td>
                            <td><?= htmlspecialchars($s['year_level']) ?></td>
                            <td><?= htmlspecialchars($s['section']) ?></td>
                            <td><?= htmlspecialchars($s['student_status']) ?></td>
                            <td style="height:30px;"></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No students in this masterlist yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Signature Blocks -->
            <br><br>
            <div style="display:flex; justify-content:space-between; margin-top:40px; font-size:13px;">
                <div style="text-align:center; width:30%;">
                    <p>Prepared by:</p><br>
                    <p>_________________________</p>
                    <p>Registrar Staff</p>
                </div>
                <div style="text-align:center; width:30%;">
                    <p>Checked by:</p><br>
                    <p>_________________________</p>
                    <p>Head Registrar</p>
                </div>
                <div style="text-align:center; width:30%;">
                    <p>Approved by:</p><br>
                    <p>_________________________</p>
                    <p>School Director</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function openCreateModal() { document.getElementById("createModal").style.display = "flex"; }
function closeCreateModal() { document.getElementById("createModal").style.display = "none"; }
function openNoSectionModal() { document.getElementById("noSectionModal").style.display = "flex"; }
function closeNoSectionModal() { document.getElementById("noSectionModal").style.display = "none"; }
</script>

</body>
</html>