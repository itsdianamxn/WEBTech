<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}

require_once '../model/User.php';
require_once '../model/Group.php';

$userId = $_SESSION['id'];
$user = new User();
$user->load($userId);

$response = ['status' => 'success'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $groupName = $_POST['groupName'];
    $group = new Group();
    if ($group->findByName($userId, $groupName)) {
        $response['status'] = 'error';
        $response['message'] = 'A group with this name already exists';
    } else {
        $group->setName($groupName);
        $group->setParentID($userId);
        $group->add();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
