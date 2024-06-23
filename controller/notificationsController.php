<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();
    if (!(array_key_exists('id', $_SESSION))) {
        header("Location: ../view/login.html");
        exit();
    }
$userId = $_SESSION['id'];

require_once '../model/Notification.php';
require_once '../model/User.php';
$user = new User();
$user->load($userId);

$notifications = [];
$notifications = $user->getAllUserNotifications();
$endl = "\n";
error_log(json_encode($notifications));
foreach($notifications as $notification){
    echo '<li class = "notification">' . $endl;
    echo '<p class = "notification-text">' . $endl;
    echo $notification->getMessage() . $endl;
    echo '</p>' . $endl;
    if($notification->getRead() == false){
        error_log('new notification');
        echo '<div class = "new-notification-header">' . $endl;
    }
    else{
        error_log('old notification');
        echo '<div class = "old-notification-header">' . $endl;
    }
    echo '<h3 class="notification-title">' . $endl;
    echo $notification->getTitle() . $endl;
    echo '</h3>' . $endl;
    echo '<p class="notification-time">' . $endl;
    echo $notification->getElapsedTime()->format('%d days %h hours %i minutes ago') . $endl;
    echo '</p>' . $endl;
    echo '</div>' . $endl;
    echo '</li>' . $endl;
    $notification->setRead(true);
}

?>