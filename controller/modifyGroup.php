<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();

if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}

$user_id = $_SESSION['id'];
require_once '../model/User.php';
require_once '../model/Group.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the group ID from the POST data
    $groupId = isset($_POST['groupId']) ? $_POST['groupId'] : null;
    
    if ($groupId == null) {
        echo json_encode(['status' => 'error', 'message' => 'Group ID not provided']);
        exit();
    }

    // Load the group
    $group = new Group();
    $group->load($groupId);

    if (!$group) {
        echo json_encode(['status' => 'error', 'message' => 'Group not found']);
        exit();
    }

    // Assuming there are fields 'name' and 'description' in the form
    $newName = isset($_POST['newName']) ? $_POST['newName'] : $group->getName();

    if($group->findByName($userId, $newName)){
        echo json_encode(['status' => 'error', 'message' => 'Group name already exists']);
        exit();
    }else{
        $group->setName($newName);
    // Save the updated group
        if ($group->modify()) {
            echo json_encode(['status' => 'success', 'message' => 'Group updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update group']);
        }
}

    exit();
}
?>
