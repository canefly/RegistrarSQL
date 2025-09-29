<?php
require_once __DIR__ . "/../Database/session-checker.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>School Forms</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background: #f9f9f9;
      margin: 0;
      color: #000;
    }

    .container { margin-left:240px; padding:30px; }
    .forms-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px; }
    .form-card {
      background:#fff; padding:20px; border-radius:12px;
      box-shadow:0 2px 6px rgba(0,0,0,0.1);
      text-align:center; transition:.2s;
    }
    .form-card:hover { transform:translateY(-5px); }
    .form-card i { font-size:40px; color:#0056d2; margin-bottom:10px; }
    .form-card button { margin-top:10px; padding:8px 14px; border:none;
      border-radius:6px; background:#0056d2; color:#fff; cursor:pointer; }
    .form-card button:hover { background:#003c94; }

    /* Official form style */
    @page { size: 8.5in 13in; margin: 1in; }
    .official-form {
      display:none; background:#fff;
      max-width:850px; margin:30px auto;
      padding:40px 60px; line-height:1.6;
      border:1px solid #ccc; border-radius:8px;
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
      position: relative; min-height: 100vh;
    }
    .form-header { text-align:center; margin-bottom:30px; }
    .form-header img { display:block; margin:0 auto 10px; width:90px; }
    .form-header h2 { margin:0; font-size:22px; font-weight:700; }
    .form-header h3 { margin:5px 0; font-size:18px; font-weight:600; color:#333; }

    label { display:block; margin:14px 0 6px; font-weight:600; font-size:14px; }
    input, textarea {
      display:block; width:100%;
      margin-bottom:14px; padding:10px;
      border:1px solid #aaa; border-radius:6px;
      font-size:14px; background:#fafafa;
    }
    textarea { resize:vertical; }

    .signature-line { margin-top:60px; display:flex; justify-content:space-between; }
    .signature { text-align:center; width:45%; font-size:14px; }
    .signature span {
      display:block; border-top:1px solid #000;
      margin-top:70px; padding-top:5px; font-weight:500;
    }

    .download-btn {
      margin-top:25px; background:#16a34a; color:#fff;
      padding:12px 24px; border:none; border-radius:6px;
      cursor:pointer; font-size:14px;
    }
    .download-btn:hover { background:#0e7c2f; }

    .form-footer {
      text-align:center; font-size:12px;
      border-top:1px solid #000; padding-top:10px;
      margin-top:80px; color:#333;
      position:absolute; bottom:30px; left:0; right:0;
    }

    @media print {
      body { background:#fff; }
      .form-card,.container > h1,.forms-grid,.download-btn { display:none !important; }
      .official-form { border:none; box-shadow:none; max-width:100%; margin:0; }
      .form-footer { position:absolute; bottom:20px; }
    }
  </style>
</head>
<body>

<?php include 'StudentSidenav.php'; ?>

<div class="container">
  <h1>📑 Official School Forms</h1>
  <p>Select a form below, fill it out, and download as PDF.</p>

  <div class="forms-grid">
    <div class="form-card"><i class="fa-solid fa-user-graduate"></i><h3>Transferee Form</h3><button onclick="openForm('transferee')">Open</button></div>
    <div class="form-card"><i class="fa-solid fa-user-minus"></i><h3>Dropping Form</h3><button onclick="openForm('dropping')">Open</button></div>
    <div class="form-card"><i class="fa-solid fa-calendar-days"></i><h3>Leave of Absence</h3><button onclick="openForm('leave')">Open</button></div>
    <div class="form-card"><i class="fa-solid fa-id-card"></i><h3>ID Replacement</h3><button onclick="openForm('idreplace')">Open</button></div>
    <div class="form-card"><i class="fa-solid fa-book-open"></i><h3>Change of Program</h3><button onclick="openForm('changeprog')">Open</button></div>
    <div class="form-card"><i class="fa-solid fa-certificate"></i><h3>Good Moral Request</h3><button onclick="openForm('goodmoral')">Open</button></div>
  </div>
</div>

<!-- ================== FORMS ================== -->

<!-- Transferee Form -->
<div id="transferee" class="official-form">
  <div class="form-header">
    <img src="../components/img/bcpp.png" alt="Logo">
    <h2>Bestlink College of the Philippines</h2>
    <h3>Transferee Application Form</h3>
  </div>
  <form>
    <label>Full Name</label><input type="text">
    <label>Student ID</label><input type="text">
    <label>Current Program</label><input type="text">
    <label>School Transferring To</label><input type="text">
    <label>Reason for Transfer</label><textarea rows="3"></textarea>
    <div class="signature-line"><div class="signature"><span>Student’s Signature</span></div><div class="signature"><span>Registrar</span></div></div>
    <button type="button" class="download-btn" onclick="downloadForm('transferee')">📥 Download PDF</button>
  </form>
  <div class="form-footer">Registrar’s Office • Bestlink College of the Philippines <br>1071 Brgy. Kaligayahan, Quirino Highway, Quezon City • Tel: (02) 1234-5678</div>
</div>

<!-- Dropping Form -->
<div id="dropping" class="official-form">
  <div class="form-header">
    <img src="../components/img/bcpp.png" alt="Logo">
    <h2>Bestlink College of the Philippines</h2>
    <h3>Dropping Form</h3>
  </div>
  <form>
    <label>Full Name</label><input type="text">
    <label>Student ID</label><input type="text">
    <label>Subjects to Drop</label><textarea rows="3"></textarea>
    <label>Reason</label><textarea rows="3"></textarea>
    <div class="signature-line"><div class="signature"><span>Student</span></div><div class="signature"><span>Registrar</span></div></div>
    <button type="button" class="download-btn" onclick="downloadForm('dropping')">📥 Download PDF</button>
  </form>
  <div class="form-footer">Registrar’s Office • Bestlink College of the Philippines <br>1071 Brgy. Kaligayahan, Quirino Highway, Quezon City • Tel: (02) 1234-5678</div>
</div>

<!-- Leave of Absence -->
<div id="leave" class="official-form">
  <div class="form-header">
    <img src="../components/img/bcpp.png" alt="Logo">
    <h2>Bestlink College of the Philippines</h2>
    <h3>Leave of Absence</h3>
  </div>
  <form>
    <label>Full Name</label><input type="text">
    <label>Student ID</label><input type="text">
    <label>Program & Year</label><input type="text">
    <label>Duration of Leave</label><input type="text" placeholder="e.g., 1 Semester">
    <label>Reason</label><textarea rows="3"></textarea>
    <div class="signature-line"><div class="signature"><span>Student</span></div><div class="signature"><span>Dean / Registrar</span></div></div>
    <button type="button" class="download-btn" onclick="downloadForm('leave')">📥 Download PDF</button>
  </form>
  <div class="form-footer">Registrar’s Office • Bestlink College of the Philippines <br>1071 Brgy. Kaligayahan, Quirino Highway, Quezon City • Tel: (02) 1234-5678</div>
</div>

<!-- ID Replacement -->
<div id="idreplace" class="official-form">
  <div class="form-header">
    <img src="../components/img/bcpp.png" alt="Logo">
    <h2>Bestlink College of the Philippines</h2>
    <h3>ID Replacement Form</h3>
  </div>
  <form>
    <label>Full Name</label><input type="text">
    <label>Student ID</label><input type="text">
    <label>Reason for Replacement</label><textarea rows="3" placeholder="Lost / Damaged"></textarea>
    <label>Attach Police/Barangay Report (if lost)</label><input type="file">
    <div class="signature-line"><div class="signature"><span>Student</span></div><div class="signature"><span>Registrar</span></div></div>
    <button type="button" class="download-btn" onclick="downloadForm('idreplace')">📥 Download PDF</button>
  </form>
  <div class="form-footer">Registrar’s Office • Bestlink College of the Philippines <br>1071 Brgy. Kaligayahan, Quirino Highway, Quezon City • Tel: (02) 1234-5678</div>
</div>

<!-- Change of Program -->
<div id="changeprog" class="official-form">
  <div class="form-header">
    <img src="../components/img/bcpp.png" alt="Logo">
    <h2>Bestlink College of the Philippines</h2>
    <h3>Change of Program</h3>
  </div>
  <form>
    <label>Full Name</label><input type="text">
    <label>Student ID</label><input type="text">
    <label>Current Program</label><input type="text">
    <label>Desired Program</label><input type="text">
    <label>Reason</label><textarea rows="3"></textarea>
    <div class="signature-line"><div class="signature"><span>Student</span></div><div class="signature"><span>Registrar / Dean</span></div></div>
    <button type="button" class="download-btn" onclick="downloadForm('changeprog')">📥 Download PDF</button>
  </form>
  <div class="form-footer">Registrar’s Office • Bestlink College of the Philippines <br>1071 Brgy. Kaligayahan, Quirino Highway, Quezon City • Tel: (02) 1234-5678</div>
</div>

<!-- Good Moral Request -->
<div id="goodmoral" class="official-form">
  <div class="form-header">
    <img src="../components/img/bcpp.png" alt="Logo">
    <h2>Bestlink College of the Philippines</h2>
    <h3>Good Moral Certificate Request</h3>
  </div>
  <form>
    <label>Full Name</label><input type="text">
    <label>Student ID</label><input type="text">
    <label>Purpose</label><input type="text" placeholder="e.g., Scholarship, Job Application">
    <div class="signature-line"><div class="signature"><span>Student</span></div><div class="signature"><span>Registrar</span></div></div>
    <button type="button" class="download-btn" onclick="downloadForm('goodmoral')">📥 Download PDF</button>
  </form>
  <div class="form-footer">Registrar’s Office • Bestlink College of the Philippines <br>1071 Brgy. Kaligayahan, Quirino Highway, Quezon City • Tel: (02) 1234-5678</div>
</div>

<script>
function openForm(id) {
  document.querySelectorAll(".official-form").forEach(f => f.style.display="none");
  document.getElementById(id).style.display="block";
  window.scrollTo({ top:0, behavior:"smooth" });
}
function downloadForm(id) {
  const form = document.getElementById(id).innerHTML;
  const css = document.querySelector('style').outerHTML; // include styles
  const win = window.open('', '_blank');
  win.document.write(`<html><head><title>Form</title>${css}</head><body>${form}</body></html>`);
  win.document.close();
  win.print();
}
</script>

</body>
</html>
