<?php
require_once __DIR__ . "/../Database/connection.php";
require_once __DIR__ . "/../Database/session-checker.php";
require_once __DIR__ . "/../Database/functions.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $file_type = $_POST['doc_type'];
    $file = $_FILES['document'];
    $uploaded_by = $_SESSION['user_id'];

    if ($file['error'] === 0) {
        $file_name = time() . "_" . basename($file['name']);
        $target_dir = __DIR__ . "/../uploads/docs/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $path = "/uploads/docs/" . $file_name;
            $stmt = $conn->prepare("
                INSERT INTO file_storage (student_id, file_type, file_path, uploaded_by, upload_date)
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->bind_param("sssi", $student_id, $file_type, $path, $uploaded_by);
            $stmt->execute();

            // ✅ Fetch student name for more descriptive log
            $student_stmt = $conn->prepare("SELECT first_name, last_name FROM students WHERE student_id = ?");
            $student_stmt->bind_param("s", $student_id);
            $student_stmt->execute();
            $student = $student_stmt->get_result()->fetch_assoc();
            $student_stmt->close();

            $full_name = $student ? "{$student['first_name']} {$student['last_name']}" : "Unknown Student";

            // ✅ Add system log entry
            addSystemLog(
                $conn,
                'INFO',
                "Uploaded document '{$file_type}' for {$full_name} (ID: {$student_id})",
                'staff/upload_student_file.php',
                $_SESSION['user_id']
            );



            echo "<script>alert('File uploaded successfully!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Upload failed.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error uploading file.'); window.history.back();</script>";
    }
}
?>
