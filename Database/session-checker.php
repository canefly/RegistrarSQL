<?php
// role_check.php
session_start();
require_once "connection.php"; // your mysqli/pdo connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// fetch role_id from DB
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT role_id FROM users WHERE user_id = ? AND active = 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    session_destroy();
    header("Location: ../index.php?error=inactive");
    exit();
}

// store role_id in session for re-use
$_SESSION['role_id'] = $user['role_id'];

// role-based redirects
function requireRole($roleName) {
    $roles = [
        1 => "Admin",
        2 => "Employee",
        3 => "Student"
    ];

    if (!isset($_SESSION['role_id']) || $roles[$_SESSION['role_id']] !== $roleName) {
        header("Location: ../index.php");
        exit();
    }
}
?>
