<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

require_once "../model/Database.php";

header('Content-Type: application/json');

try {
    $database = new Database();
    $pdo = $database->getConnection(); // Assuming you have a method to get PDO connection
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $data = [];

    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT * FROM $table");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data[$table] = $result;
    }

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
