<?php
require_once __DIR__ . "/../../Database/session-checker.php";
require_once __DIR__ . "/../../Database/connection.php";
header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);
$user_id = intval($input['user_id'] ?? 0);
$new_password = trim($input['new_password'] ?? '');

if (!$user_id || strlen($new_password) < 1) {
  echo json_encode(['success'=>false,'message'=>'Invalid input']);
  exit;
}

// ⚠️ store as plain text (for now)
$stmt = $conn->prepare("UPDATE users SET password_hash=? WHERE user_id=?");
$stmt->bind_param("si", $new_password, $user_id);

if ($stmt->execute()) {
  echo json_encode(['success'=>true,'message'=>'Password updated successfully!']);
} else {
  echo json_encode(['success'=>false,'message'=>'Database error']);
}
