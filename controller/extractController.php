<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];
require_once "../model/User.php";
require_once "../model/Child.php";


header('Content-Type: application/json');

try {
    $user = new User();
    $user->load($userId);
    $userArray = [
        'id' => $user->getId(),
        'firstname' => $user->getFirstname(),
        'lastname' => $user->getLastname(),
        'email' => $user->getEmail(),
        'relationship' => $user->getRelation(),
        'dob' => $user->getDob(),
    ];
    $data['users'] = $userArray;

    $children = $user->getChildren();
    $childArray = [];
    $pictures = [];
    foreach($children as $child) {
        $childArray[] = [
            'id' => $child->getId(),
            'firstname' => $child->getFirstname(),
            'lastname' => $child->getLastname(),
            'dob' => $child->getDob(),];
        $pictures[] = $child->getPictures();
    }
    $data['children'] = $childArray;
    $picturesArray = [];
    foreach($pictures as $picture){
        foreach($picture as $pic){
            $picturesArray[] = [
                'id' => $pic->getId(),
                'childID' => $pic->getChildID(),
                'path' => $pic->getPicture(),
                'date' => $pic->getDate(),
                'timeline' => $pic->getTimeline(),
            ];
        }
    }
    $data['pictures'] = $picturesArray;


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
