<?php
$host = 'localhost';
$dbname = 'sms';
$username = 'root';

// Try blank password first (XAMPP-style)
$passwords = ['', 'Scara1313'];
$conn = null;

foreach ($passwords as $password) {
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if (!$conn->connect_error) {
        break; // success!
    }
}

// Final check if connection worked
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Optional: echo which method worked
// echo "Connected using password: " . ($password === '' ? 'blank' : $password);
?>
