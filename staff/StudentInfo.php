<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Records</title>
  <link rel="stylesheet" href="../css/StudentInfo.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'StaffSidenav.php'; ?>
<div class="container">



  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Search student...">
  </div>


  <table>
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Course</th>
        <th>Section</th>
        <th>Student ID</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- Example rows -->
      <tr>
        <td>Juan Dela Cruz</td>
        <td>BSIT</td>
        <td>2201</td>
        <td>2025-001</td>
        <td><button onclick="showDetails(0)">View Details</button></td>
      </tr>
      <tr>
        <td>Maria Santos</td>
        <td>BSA</td>
        <td>3102</td>
        <td>2025-002</td>
        <td><button onclick="showDetails(1)">View Details</button></td>
      </tr>
      <tr>
        <td>Carlos Reyes</td>
        <td>BSBA</td>
        <td>1101</td>
        <td>2025-003</td>
        <td><button onclick="showDetails(2)">View Details</button></td>
      </tr>
    </tbody>
  </table>
</div>

  <!-- Modal -->
  <div id="modal" class="modal">
    <div id="modalContent" class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <div id="studentDetails"></div>
    </div>
  </div>

<!-- ID Preview Modal -->
<div id="idPreviewModal" class="modal">
  <div class="modal-content" style="max-width: 400px;">
    <span class="close" onclick="closeIdPreview()">&times;</span>
    <div id="idCardPreview"></div>
    <button onclick="confirmPrint()" style="margin-top:10px;">Print ID</button>
  </div>
</div>

<!-- Hidden print-only container -->
<div id="idCard"></div>

<script>
// Sample student data
const students = [
  {
    name: "Juan Dela Cruz",
    course: "BSIT",
    section: "2201",
    id: "2025-001",
    age: 20,
    birthday: "2005-03-14",
    address: "Caloocan City",
    guardian: "Pedro Dela Cruz - 09123456789",
    academic: `
      <ul>
        <li><b>Elementary:</b> Quezon City Elementary School (2011–2016)</li>
        <li><b>High School:</b> Benigno Aquino Jr. High School (2016–2020)</li>
        <li><b>Senior High:</b> Bestlink College of the Philippines (2020–2022)</li>
      </ul>
    `,
    medical: "No medical issues",
    status: "Active",
    picture: "../img/sample-student1.jpg"
  },
  {
    name: "Maria Santos",
    course: "BSA",
    section: "3102",
    id: "2025-002",
    age: 21,
    birthday: "2004-07-10",
    address: "Quezon City",
    guardian: "Ana Santos - 09987654321",
    academic: `
      <ul>
        <li><b>Elementary:</b> Quezon City Elementary School (2010–2015)</li>
        <li><b>High School:</b> Benigno Aquino Jr. High School (2015–2019)</li>
        <li><b>Senior High:</b> Bestlink College of the Philippines (2019–2021)</li>
      </ul>
    `,
    medical: "Allergic to peanuts",
    status: "Active",
    picture: "../img/sample-student2.jpg"
  },
  {
    name: "Carlos Reyes",
    course: "BSBA",
    section: "1101",
    id: "2025-003",
    age: 22,
    birthday: "2003-11-22",
    address: "Manila",
    guardian: "Jose Reyes - 09112223333",
    academic: `
      <ul>
        <li><b>Elementary:</b> Manila Central School (2009–2014)</li>
        <li><b>High School:</b> Benigno Aquino Jr. High School (2014–2018)</li>
      </ul>
    `,
    medical: "Asthma",
    status: "Dropped",
    picture: "../img/sample-student3.jpg"
  }
];

let lastIndex = null;
function showDetails(index) {
  const s = students[index];
  const details = `
    <h2>${s.name}</h2>
    <img src="${s.picture}" alt="Student Picture">
    <p><b>Course & Section:</b> ${s.course} - ${s.section}</p>
    <p><b>Student ID:</b> ${s.id}</p>
    <p><b>Age:</b> ${s.age}</p>
    <p><b>Birthday:</b> ${s.birthday}</p>
    <p><b>Address:</b> ${s.address}</p>
    <p><b>Guardian & Emergency Contact:</b> ${s.guardian}</p>
    <p><b>Academic History:</b> ${s.academic}</p>
    <p><b>Medical History:</b> ${s.medical}</p>
    <p><b>Status Tracker:</b> 
      <select>
        <option ${s.status === "Active" ? "selected" : ""}>Active</option>
        <option ${s.status === "Dropped" ? "selected" : ""}>Dropped</option>
      </select>
    </p>
    <button onclick="printID(${index})">Print ID</button>
  `;
  document.getElementById("studentDetails").innerHTML = details;
  document.getElementById("modal").style.display = "flex";
  lastIndex = index;
}

function closeModal() {
  document.getElementById("modal").style.display = "none";
  lastIndex = null;
}

//Print ID Function
let currentStudent = null;

function printID(index) {
  const s = students[index];
  currentStudent = s;

  // Fill preview
  const preview = document.getElementById("idCardPreview");
  preview.innerHTML = `
    <div class="id-front">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
        <img src="../img/bcpp.png" style="width:40px;height:40px;">
        <div>
          <h3>Bestlink College of the Philippines</h3>
          <small>Student ID</small>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:12px;">
        <img src="${s.picture}" alt="Student Photo" style="width:70px;height:90px;border:1px solid #000;">
        <div>
          <p><b>${s.name}</b></p>
          <p>${s.course} - ${s.section}</p>
          <p>ID: ${s.id}</p>
        </div>
      </div>
    </div>

    <div class="id-back">
      <h3>Student Information</h3>
      <p><b>Guardian:</b> ${s.guardian}</p>
      <p><b>Address:</b> ${s.address}</p>
      <p><b>Medical:</b> ${s.medical}</p>
      <br>
      <small>If found, please return to Bestlink College of the Philippines</small>
    </div>
  `;

  document.getElementById("idPreviewModal").style.display = "flex";
}

function closeIdPreview() {
  document.getElementById("idPreviewModal").style.display = "none";
}

function confirmPrint() {
  if (!currentStudent) return;
  const s = currentStudent;
  const idCard = document.getElementById("idCard");

  // Put only front & back into hidden print container
  idCard.innerHTML = document.getElementById("idCardPreview").innerHTML;
  idCard.style.display = "block";

  window.print();

  // cleanup
  idCard.style.display = "none";
  idCard.innerHTML = "";
  closeIdPreview();
}

</script>

</body>
</html>
