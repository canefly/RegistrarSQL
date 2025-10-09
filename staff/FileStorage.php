<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/functions.php";

include "StaffSidenav.php";
requireRole("Employee");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Digital File Storage</title>
  <link rel="icon" sizes="32x32" href="../components/img/bcpp.png">
  <link rel="icon" sizes="192x192" href="../components/img/bcpp.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background: #f4f6fb;
      margin: 0;
      display: flex;
    }
   

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

 h1 {
  font-size: 32px;
  margin-bottom: 10px;
}

 p {
  font-size: 18px;
  color: #555;
}
.header-bar {
  width: 100%;
  max-width: 1200px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 6px;
  margin: 0 0 18px 0;
  padding-top: 10px;
}
.search-bar { position: relative; width: 100%; max-width: 360px; }
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
.suggestions {
  position: absolute;
  background: #fff;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  width: 100%;
  box-shadow: 0 4px 8px rgba(0,0,0,0.08);
  margin-top: 5px;
  max-height: 200px;
  overflow-y: auto;
  z-index: 1000;
}
.suggestions div {
  padding: 8px 12px;
  cursor: pointer;
  transition: background 0.2s ease;
}
.suggestions div:hover { background: #f1f5ff; }


    button {
      background: #0056d2;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background: #0040a8;
    }
    .file-card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
   .upload-section {
    margin-top: 15px;
    background: linear-gradient(135deg, #f9fbff 0%, #eef3ff 100%);
    border: 1px solid #d8e3ff;
    padding: 25px;
    border-radius: 12px;
    text-align: left;
    box-shadow: 0 3px 10px rgba(0, 86, 210, 0.05);
    transition: all 0.3s ease;
    position: relative;
    }

    .upload-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 86, 210, 0.12);
    border-color: #0056d2;
    }

    .upload-section form {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
    }

    .upload-section input[type="file"] {
    display: none;
    }

    .file-label {
    background: #0056d2;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background 0.3s ease;
    }

    .file-label:hover {
    background: #003b99;
    }

    .file-name {
    font-size: 13px;
    color: #d7d2d2;
    padding: 0 6px;
    font-style: italic;
    }

    .upload-section input[list] {
    padding: 10px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    flex: 1;
    min-width: 220px;
    transition: border 0.3s ease;
    }

    .upload-section input[list]:focus {
    border-color: #0056d2;
    box-shadow: 0 0 4px rgba(0,86,210,0.2);
    outline: none;
    }

    .upload-btn {
    background: #00a86b;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background 0.3s ease, transform 0.2s;
    }

    .upload-btn:hover {
    background: #008a59;
    transform: translateY(-1px);
    }

    .upload-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    }

    .upload-header i {
    color: #0056d2;
    font-size: 18px;
    }

    .upload-header h4 {
    font-size: 16px;
    color: #003b99;
    margin: 0;
    }

    .doc-list {
      margin-top: 20px;
    }
    .doc-list table {
      width: 100%;
      border-collapse: collapse;
    }
    .doc-list th, .doc-list td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    .doc-list th {
      background: #0056d2;
      color: #fff;
    }
    .status-complete { color: green; font-weight: bold; }
    .status-pending { color: orange; font-weight: bold; } 

    

    /* Modal Styling */
.modal {
  display: none;
  position: fixed;
  z-index: 10000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
}

.modal-content {
  background-color: #fff;
  margin: 3% auto;
  padding: 0;
  border-radius: 10px;
  width: 80%;
  height: 85%;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.modal-content iframe {
  flex: 1;
  width: 100%;
  border: none;
}

.close {
  color: #333;
  font-size: 28px;
  font-weight: bold;
  text-align: right;
  padding: 10px 20px;
  cursor: pointer;
}

.close:hover {
  color: #e00;
}
  </style>
</head>
<body>
<div class="content">
 <div class="header-bar">
  <h1>Digital File Storage</h1>
  <p>Manage and upload student documents efficiently.</p>

  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search student by ID or name..." autocomplete="off">
    <div id="suggestionsBox" class="suggestions" style="display:none;"></div>
  </div>
</div>

<!-- Empty state under header; shown only when no card matches -->
<div id="emptyState" style="display:none; color:#666; font-style:italic; margin:10px 0;">
  No students found.
</div>


  <div id="studentContainer">
    <?php
    $query = $conn->query("SELECT student_id, first_name, last_name, year_level, section FROM students ORDER BY last_name ASC");
    while ($row = $query->fetch_assoc()) {
        echo "
                <div class='file-card student-card' data-name='{$row['first_name']} {$row['last_name']}' data-id='{$row['student_id']}'>
                <h3>{$row['first_name']} {$row['last_name']} ({$row['student_id']})</h3>
                <p><b>Year Level:</b> {$row['year_level']} | <b>Section:</b> {$row['section']}</p>

                <div class='upload-section'>
                    <div class='upload-header'>
                    <i class='fas fa-cloud-upload-alt'></i>
                    <h4>Upload New Document</h4>
                    </div>

                    <form action='upload_student_file.php' method='POST' enctype='multipart/form-data' class='upload-form'>
                    <input type='hidden' name='student_id' value='{$row['student_id']}'>

                    <label class='file-label'>
                        <i class='fas fa-file-upload'></i> Choose File
                        <input type='file' name='document' required hidden onchange=\"this.parentNode.querySelector('.file-name').textContent = this.files[0] ? this.files[0].name : 'No file chosen';\">
                        <span class='file-name'>No file chosen</span>
                    </label>

                    <input list='docTypes' name='doc_type' class='doc-input' placeholder='Enter or select file type...' required>
                    <datalist id='docTypes'>
                        <option value='Form 137'>
                        <option value='Good Moral'>
                        <option value='Birth Certificate'>
                        <option value='Transcript of Records'>
                        <option value='Report Card'>
                        <option value='Honorable Dismissal'>
                        <option value='Voucher'>
                    </datalist>

                    <button type='submit' class='upload-btn'><i class='fas fa-upload'></i> Upload</button>
                    </form>
                </div>";

        // list uploaded files
        $docs = $conn->prepare("SELECT file_type, file_path, upload_date FROM file_storage WHERE student_id = ?");
        $docs->bind_param("s", $row['student_id']);
        $docs->execute();
        $files = $docs->get_result();

        echo "<div class='doc-list'><h4>Uploaded Documents</h4>";
        if ($files->num_rows > 0) {
            echo "<table><tr><th>Type</th><th>File</th><th>Date</th></tr>";
            while ($d = $files->fetch_assoc()) {
                echo "<tr>
                        <td>{$d['file_type']}</td>
                        <td><a href='#' class='view-file' data-src='../{$d['file_path']}'>View</a></td>
                        <td>{$d['upload_date']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='status-pending'>No files uploaded yet.</p>";
        }
        echo "</div></div>";
    }
    ?>
  </div>
 </div>
    <div id="previewModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <iframe id="previewFrame" src="" frameborder="0"></iframe>
    </div>
  <script>
  const searchInput = document.getElementById('searchInput');
  const cards = Array.from(document.querySelectorAll('.student-card'));
  const suggestionsBox = document.getElementById('suggestionsBox');
  const emptyState = document.getElementById('emptyState');

  // Live filter + suggestions (mirrors StudentInfo behavior)
  searchInput.addEventListener('keyup', function () {
    const filter = this.value.toLowerCase().trim();
    let matches = [];

    let visibleCount = 0;
    cards.forEach(card => {
      const name = card.dataset.name.toLowerCase();
      const id = card.dataset.id.toLowerCase();
      const hit = name.includes(filter) || id.includes(filter);

      card.style.display = hit ? 'block' : 'none';
      if (hit) {
        visibleCount++;
        if (filter) matches.push({ label: `${card.dataset.name} (${card.dataset.id})`, key: name });
      }
    });

    // Empty state under header
    emptyState.style.display = (filter && visibleCount === 0) ? 'block' : 'none';

    // Suggestions
    suggestionsBox.innerHTML = '';
    if (filter && matches.length > 0) {
      suggestionsBox.style.display = 'block';
      matches.slice(0, 5).forEach(m => {
        const div = document.createElement('div');
        div.innerHTML = m.label.replace(new RegExp(`(${filter})`, 'gi'), '<b>$1</b>');
        div.onclick = () => {
          // Show only the selected card and scroll to it
          cards.forEach(c => c.style.display = (c.dataset.name.toLowerCase() === m.key) ? 'block' : 'none');
          const target = cards.find(c => c.dataset.name.toLowerCase() === m.key);
          if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          searchInput.value = m.label;
          suggestionsBox.style.display = 'none';
          emptyState.style.display = 'none';
        };
        suggestionsBox.appendChild(div);
      });
    } else {
      suggestionsBox.style.display = 'none';
    }
  });

  // Close suggestions when clicking outside
  document.addEventListener('click', (e) => {
    if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
      suggestionsBox.style.display = 'none';
    }
  });

 
    const modal = document.getElementById("previewModal");
    const frame = document.getElementById("previewFrame");
    const closeBtn = document.querySelector(".close");

    document.querySelectorAll(".view-file").forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        const src = link.dataset.src;
        frame.src = src;
        modal.style.display = "block";
    });
    });

    closeBtn.onclick = () => {
    modal.style.display = "none";
    frame.src = "";
    };

    window.onclick = (e) => {
    if (e.target == modal) {
        modal.style.display = "none";
        frame.src = "";
    }
    };
  </script>

</div>
</body>
</html>
