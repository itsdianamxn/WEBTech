<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../errors.log');
session_start();

if (!array_key_exists('id', $_SESSION)) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

require_once '../model/Group.php';
require_once '../model/Group_Children.php';

$userId = $_SESSION['id'];

try {
    $groupModel = new Group();
    $groups = $groupModel->getAllGroups($userId);

    $groupChildren = [];
    foreach ($groups as $group) {
        $gc = new Group_Children();
        $children = $gc->getAllChildrenFromGroup($group['id']);

        $groupChildren[$group['id']] = $children;
    }
    error_log("HERE " . json_encode($groupChildren));
    echo json_encode(['status' => 'success', 'groups' => $groups, 'groupChildren' => $groupChildren]);
} catch (Exception $e) {
    error_log("Failed to fetch groups: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch groups']);
}
exit();
?>
