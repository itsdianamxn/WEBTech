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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $groupId = isset($data['groupId']) ? $data['groupId'] : null;

    if ($groupId == null) {
        echo json_encode(['status' => 'error', 'message' => 'Group ID not provided']);
        exit();
    } else {
        $group = new Group();
        $group->load($groupId);
        error_log("Group: " . json_encode($group));
        if (!$group) {
            echo json_encode(['status' => 'error', 'message' => 'Group not found']);
            exit();
        } else {
            $group->delete();
            echo json_encode(['status' => 'success', 'message' => 'Group deleted successfully']);
            exit();
        }
    }
}
exit();
?>
