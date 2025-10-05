<?php
require_once __DIR__ . "/../Database/session-checker.php";

$formsDir = __DIR__ . '/forms';
$files = glob($formsDir . '/*');

$forms = [];

foreach ($files as $file) {
    $filename = basename($file);
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Clean title: replace underscores/hyphens with spaces and capitalize words
    $title = pathinfo($filename, PATHINFO_FILENAME);
    $title = str_replace(['_', '-'], ' ', $title);
    $title = ucwords($title);

    // Choose icon based on extension
    switch ($extension) {
        case 'pdf': $iconClass = 'fa-solid fa-file-pdf'; break;
        case 'doc':
        case 'docx': $iconClass = 'fa-solid fa-file-word'; break;
        case 'xls':
        case 'xlsx': $iconClass = 'fa-solid fa-file-excel'; break;
        default: $iconClass = 'fa-solid fa-file'; break;
    }

    $forms[] = [
        'title' => $title,
        'file' => 'forms/' . $filename,
        'icon' => $iconClass
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>School Forms</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">

<style>
/* ----------------- Global CSS for offset effect ----------------- */
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}

/* Sidebar offset container */
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
    left: 20px !important;
  }
}

/* ----------------- Forms Grid Styling ----------------- */
h1 { font-size: 26px; margin-bottom: 8px; }
p { margin-bottom: 24px; color: #444; }

.forms-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; }

.form-card {
  background: #fff;
  padding: 24px 20px;
  border-radius: 14px;
  border: 1px solid #e0e4ea;
  text-align: center;
  box-shadow: 0 3px 12px rgba(0,0,0,0.06);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.3s ease, box-shadow 0.3s ease; /* smoother transition */
}

.form-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 10px 25px rgba(0,86,210,0.15); 
}

.form-card i {
  font-size: 42px;
  color: #004aad;
  margin-bottom: 12px;
}

.form-card h3 {
  font-size: 16px;
  font-weight: 600;
  margin: 12px 0;
  color: #222;
  flex-grow: 1;
}

.form-card a button {
  margin-top: 12px;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  background: #004aad;
  color: #fff;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: 0.25s;
}

.form-card a button:hover { background: #003377; }

@media (max-width: 1024px) { .forms-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .container { margin-left: 0; padding: 20px; } .forms-grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>

<?php include 'StudentSidenav.php'; ?>

<div class="container">
  <h1>Official School Forms</h1>
  <p>Please select a form below and download as an official PDF document.</p>

  <div class="forms-grid">
    <?php if (!empty($forms)): ?>
      <?php foreach ($forms as $form): ?>
        <div class="form-card">
          <i class="<?= htmlspecialchars($form['icon']) ?>"></i>
          <h3><?= htmlspecialchars($form['title']) ?></h3>
          <a href="<?= htmlspecialchars($form['file']) ?>" download="<?= htmlspecialchars($form['title']) ?>.pdf">
            <button>Download</button>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No forms available at the moment.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
