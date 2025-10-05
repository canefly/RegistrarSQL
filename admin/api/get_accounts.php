<?php
require_once __DIR__ . "/../../Database/session-checker.php";
require_once __DIR__ . "/../../Database/connection.php";
header("Content-Type: application/json");

$type = $_GET['type'] ?? 'students';
switch ($type) {
  case 'admin': $role_id = 1; break;
  case 'staff': $role_id = 2; break;
  default: $role_id = 3;
}

$sql = "SELECT u.user_id, u.username, u.email, r.name AS role
        FROM users u JOIN roles r ON u.role_id = r.role_id
        WHERE u.role_id = ? ORDER BY u.user_id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $role_id);
$stmt->execute();
$res = $stmt->get_result();
$rows = [];
while ($r = $res->fetch_assoc()) $rows[] = $r;
echo json_encode(['success'=>true,'rows'=>$rows]);
