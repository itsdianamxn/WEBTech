<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();
if (!(array_key_exists('id', $_SESSION)))
{
    header("Location: ../view/login.html");
    exit();
}

$user_id = $_SESSION['id'];

require_once '../model/User.php';

// Assuming session_start() is called before this point if session is used

// Check if user is logged in (example check)
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Unauthorized
    exit;
}

// Initialize User object with user ID from session
$user = new User();
$user->load($user_id);

// Fetch count of unread notifications
$count = $user->getNrNotifications();

error_log("User" . $user_id. " has " . $count . "unread notifications");

// Return the count as JSON response
header('Content-Type: application/json');
echo json_encode(['count' => $count]);

?>