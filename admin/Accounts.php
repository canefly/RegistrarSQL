<?php
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/connection.php";
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Accounts Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { 
      font-family: 'Outfit', sans-serif; 
      margin: 0; 
      background: #f9fafb; 
      display: flex; 
      min-height: 100vh;
    }

    /* --- main container --- */
    .content { 
      flex: 1; 
      padding: 40px 60px; 
      margin-left: 320px; /* more space from sidebar */
      transition: margin-left 0.3s ease;
    }

    /* when sidebar collapses */
    .sidebar.collapsed ~ .content {
      margin-left: 90px;
      padding: 30px 40px;
    }

    h2 { 
      color: #1e293b; 
      margin-bottom: 1.5rem; 
      font-size: 1.8rem;
    }

    .account-switch {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.8rem;
      flex-wrap: wrap;
    }

    .switch-btn {
      padding: 10px 22px;
      border-radius: 25px;
      border: none;
      background: #f1f5f9;
      color: #1d4ed8;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .switch-btn.active { background: #1d4ed8; color: #fff; }
    .switch-btn:hover { background: #e2e8f0; }

    /* --- search bar --- */
    #searchInput {
      padding: 10px 14px;
      width: 340px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: 0.2s ease;
    }
    #searchInput:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 6px rgba(59,130,246,0.4);
      outline: none;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    th, td {
      padding: 14px 18px;
      text-align: left;
      border-bottom: 1px solid #f1f5f9;
    }
    th { 
      background: #f1f5f9; 
      font-weight: 600; 
      color: #1e293b;
      font-size: 15px;
    }
    td {
      font-size: 14px;
      color: #334155;
    }

    td button {
      padding: 7px 14px;
      background: #2563eb;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.2s;
    }
    td button:hover { background: #1d4ed8; }

    /* modal */
    .modal {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.45);
      display: flex;
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

    .save-btn { background: #2563eb; color: white; }
    .cancel-btn { background: #e2e8f0; color: #1e293b; }

    @media (max-width: 900px) {
      .content { margin-left: 0; padding: 25px; }
      #searchInput { width: 100%; }
    }
  </style>
</head>
<body>

<?php include "AdminSidenav.php"; ?>

<div class="content">
  <h2>Accounts Management</h2>

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
<div id="passwordModal" class="modal" style="display:none;">
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

// 🔍 Live search filter
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

// default load
btns[0].click();
</script>
</body>
</html>
