<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

require_once '../model/User.php';
require_once '../model/Child.php';
require_once '../model/Picture.php';
require_once '../model/Database.php';

$user = new User();
$user->load($_SESSION['id']);

header('Content-Type: application/json');
error_log($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        
        $fileType = mime_content_type($file['tmp_name']);
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($fileType === 'application/json' || $fileExtension === 'json') {
            $jsonContent = file_get_contents($file['tmp_name']);
            $data = json_decode($jsonContent, true);

            if (json_last_error() === JSON_ERROR_NONE) { 
                try {
                    if (isset($data['users'])) {
                        if ($data['users']['id'] != $user->getId()) {
                            echo json_encode(['success' => false, 'error' => 'Invalid user']);
                            exit();
                        }
                        $userData = $data['users'];
                        $user->loadFromImport($userData);
                    }   

                    if (isset($data['children'])) {
                        foreach ($data['children'] as $childData) {
                            $child = new Child();
                            $child->loadFromImport($childData, $user->getId());
                        }
                    }

                    if (isset($data['pictures'])) {
                        foreach ($data['pictures'] as $imageData) {
                            $picture = new Picture();
                            $picture->loadFromImport($imageData);
                        }
                    }

                    echo json_encode(['success' => true]);
                } catch (Exception $e) {
                    
                    echo json_encode(['success' => false, 'error' => 'Error inserting data into database: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid JSON format']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid file type. Please upload a JSON file']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No file uploaded']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
