<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
include "StaffSidenav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Digital File Storage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background: #f4f6fb;
      margin: 0;
      display: flex;
    }
    .content {
      margin-left: 240px;
      padding: 20px;
      width: 100%;
    }
    h2 {
      color: #003b99;
      margin-bottom: 20px;
    }
    .search-bar {
      margin-bottom: 15px;
    }
    input[type="text"] {
      padding: 10px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
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
    color: #d7d2d2
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
  <h2><i class="fas fa-folder-open"></i> Digital File Storage</h2>

  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search student by ID or name...">
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
  const cards = document.querySelectorAll('.student-card');

  searchInput.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    cards.forEach(card => {
      const name = card.dataset.name.toLowerCase();
      const id = card.dataset.id.toLowerCase();
      if (name.includes(filter) || id.includes(filter)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
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
