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
    $childId = $_POST['childID'];
    $groupId = $_POST['groupId'];
    $group = new Group();
    if (!$group->load($groupId)) {
        $response['status'] = 'error';
        $response['message'] = 'Group not found';
    } else {
        $group->addChild($childId);
        $response['status'] = 'success';
        $response['message'] = 'Child added to group successfully';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
