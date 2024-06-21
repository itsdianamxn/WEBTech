<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

require_once '../model/User.php';

$user = new User();
$user->load($_SESSION['id']);

header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_FILES['file'])){
        $file = $_FILES['file'];

        $fileType = mime_content_type($file['tmp_name']);
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($fileType === 'application/json' && $fileExtension === 'json'){
            $jsonContent = file_get_contents($file['tmp_name']);
            $fileExtension = pathinfo($file['name'],PATHINFO_EXTENSION);
            $data = json_decode($jsonContent, true);
            if (json_last_error() === JSON_ERROR_NONE){
                if($data['users'])
                {
                    if($data['users']['id'] != $user->getId())
                    {
                        echo json_encode(['error' => 'Invalid user']);
                        exit();
                    }
                    $user->loadFromImport($userData);
                }
                if($data['children']){
                    foreach($data['children'] as $childData)
                    {
                        $child = new Child();
                        $child->loadFromImport($childData);
                    }
                }
                if($data['images']){
                    foreach($data['images'] as $imageData)
                    {
                        $picture = new Picture();
                        $picture->loadFromImport($imageData);
                    }
                }
            }
        }
    }
}

?>
