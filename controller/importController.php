<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $file_name = basename($_FILES['file']['name']);
        $upload_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
            echo json_encode(['success' => true, 'file' => $file_name]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
