<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];
require_once "../model/Database.php";

header('Content-Type: application/json');

try {
    $database = new Database();
    $pdo = $database->getConnection(); // Assuming you have a method to get PDO connection
    $data = [];

    $stmt = $pdo->query("SELECT * FROM users where ID = " . $userId);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['users'] = $result;

    $stmt = $pdo->query("SELECT * FROM children where parent_ID = " . $userId);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['children'] = $result;

    $stmt = $pdo->query("SELECT * FROM images where child_ID in (SELECT ID FROM children where parent_ID = " . $userId . ")");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['images'] = $result;

    $json_data = json_encode($data);
    
    // Save the JSON data to a file
    $file_name = 'database_export_' . date('Y-m-d_H-i-s') . '.json';
    $file_path = '../pics/' . $file_name;
    file_put_contents($file_path, $json_data);

    echo json_encode(['file' => $file_name, 'path' => $file_path]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
