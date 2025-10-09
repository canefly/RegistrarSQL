<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
$current_page = basename($_SERVER['PHP_SELF']);
requireRole("Admin");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Accounts Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;700&display=swap" rel="stylesheet">
  <style>
/* ================== GLOBAL LAYOUT OFFSET ================== */
body {
  margin: 0;
  font-family: 'Outfit', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  min-height: 100vh;
}

.container {
  flex: 1;
  margin-left: 240px;
  padding: 25px 30px 40px 30px;
  transition: margin-left 0.3s ease;
  box-sizing: border-box;
  width: 100%;
  max-width: none;
}

.sidebar.collapsed ~ .container {
  margin-left: 70px;
}

@media (max-width: 768px) {
  .container {
    margin-left: 0;
    padding: 20px;
  }
}

/* ================== HEADER ================== */
h2 {
  color: #000000ff;
  font-weight: 700;
  margin-bottom: 10px;
  font-size: 28px;
}

p.page-sub {
  color: #555;
  font-size: 16px;
  margin-bottom: 25px;
}

/* ================== SWITCH BUTTONS ================== */
.account-switch {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.8rem;
  flex-wrap: wrap;
}

.switch-btn {
  padding: 10px 22px;
  border-radius: 25px;
  border: 1px solid #d1d5db;
  background: #f9fafb;
  color: #004aad;
  font-weight: 600;
  cursor: pointer;
  transition: all .2s ease;
}
.switch-btn.active {
  background: #004aad;
  color: #fff;
  box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}
.switch-btn:hover {
  background: #e5edff;
}

/* ================== SEARCH BAR ================== */
#searchInput {
  padding: 12px 18px;
  width: 340px;
  border: 1px solid #d1d5db;
  border-radius: 25px;
  font-size: 15px;
  margin-bottom: 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  transition: 0.2s;
}
#searchInput:focus {
  border-color: #004aad;
  box-shadow: 0 0 6px rgba(59,130,246,0.4);
  outline: none;
}

/* ================== TABLE ================== */
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  font-family: 'Outfit', sans-serif;
  font-size: 15px;
}
thead {
  background: #004aad;
  color: #fff;
}
th, td {
  padding: 13px 15px;
  text-align: center;
  border-bottom: 1px solid #eee;
}
tbody tr:nth-child(odd) {
  background: #ffffff;
}
tbody tr:nth-child(even) {
  background: #f9fafb;
}
tbody tr:hover {
  background: #f1f5ff;
  transition: background 0.25s ease;
}

/* ================== BUTTONS ================== */
td button {
  padding: 6px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  background: #004aad;
  color: white;
  transition: 0.2s;
}
td button:hover {
  background: #00378d;
}

/* ================== MODAL ================== */
.modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.45);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 2000;
  backdrop-filter: blur(3px);
}

.modal-content {
  background: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  width: 380px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.modal-content h3 { 
  margin-top: 0; 
  color: #1e293b; 
  margin-bottom: 10px; 
}

.modal-content input {
  width: 100%;
  padding: 10px 12px;
  margin: 8px 0;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 14px;
}

.modal-content button {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
}

.save-btn { background: #004aad; color: white; }
.cancel-btn { background: #e2e8f0; color: #1e293b; }

@media (max-width: 900px) {
  #searchInput { width: 100%; }
}
  </style>
</head>
<body>

<?php include "AdminSidenav.php"; ?>

<div class="container">
  <h2>Accounts Management</h2>
  <p class="page-sub">Manage all system accounts and change their passwords as needed.</p>

  <div class="account-switch">
    <button class="switch-btn active" data-type="students">Students</button>
    <button class="switch-btn" data-type="staff">Staff</button>
    <button class="switch-btn" data-type="admin">Admin</button>
  </div>

  <input type="text" id="searchInput" placeholder="Search accounts...">

  <div id="account-table">
    <p>Loading accounts...</p>
  </div>
</div>

<!-- Modal for password change -->
<div id="passwordModal" class="modal">
  <div class="modal-content">
    <h3>Change Password</h3>
    <form id="passwordForm">
      <input type="hidden" name="user_id" id="user_id">
      <label>New Password</label>
      <input type="password" name="new_password" id="new_password" required minlength="6">
      <label>Confirm Password</label>
      <input type="password" id="confirm_password" required minlength="6">
      <div style="margin-top:12px;text-align:right;">
        <button type="button" class="cancel-btn" id="cancelPassword">Cancel</button>
        <button type="submit" class="save-btn">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
const btns = document.querySelectorAll('.switch-btn');
const tableDiv = document.getElementById('account-table');
const modal = document.getElementById('passwordModal');

btns.forEach(btn => {
  btn.addEventListener('click', async () => {
    btns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const type = btn.dataset.type;
    tableDiv.innerHTML = `<p>Loading ${type} accounts...</p>`;
    const res = await fetch(`../admin/api/get_accounts.php?type=${type}`);
    const data = await res.json();

    if (data.success && data.rows.length > 0) {
      const rows = data.rows.map(r =>
        `<tr>
          <td>${r.user_id}</td>
          <td>${r.username}</td>
          <td>${r.email}</td>
          <td>${r.role}</td>
          <td><button class="change-pass" data-id="${r.user_id}" data-username="${r.username}">Change Password</button></td>
        </tr>`
      ).join('');
      tableDiv.innerHTML = `
        <table>
          <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
          <tbody>${rows}</tbody>
        </table>`;
      attachChangePass();
    } else {
      tableDiv.innerHTML = `<p>No ${type} accounts found.</p>`;
    }
  });
});

// 🔍 Live search
document.addEventListener("input", e => {
  if (e.target.id === "searchInput") {
    const filter = e.target.value.toLowerCase();
    const rows = document.querySelectorAll("#account-table tbody tr");
    rows.forEach(row => {
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? "" : "none";
    });
  }
});

function attachChangePass(){
  document.querySelectorAll('.change-pass').forEach(btn=>{
    btn.addEventListener('click',()=>{
      document.getElementById('user_id').value = btn.dataset.id;
      modal.style.display = 'flex';
    });
  });
}
document.getElementById('cancelPassword').onclick = ()=> modal.style.display='none';

document.getElementById('passwordForm').onsubmit = async e => {
  e.preventDefault();
  const newPass = document.getElementById('new_password').value;
  const confirmPass = document.getElementById('confirm_password').value;
  if (newPass !== confirmPass) return alert('Passwords do not match!');

  const res = await fetch('../admin/api/update_password.php', {
    method: 'POST',
    headers: { 'Content-Type':'application/json' },
    body: JSON.stringify({
      user_id: document.getElementById('user_id').value,
      new_password: newPass
    })
  });
  const j = await res.json();
  alert(j.message);
  if (j.success) modal.style.display='none';
};

btns[0].click();
</script>
</body>
</html>
