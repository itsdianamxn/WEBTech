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
require_once '../model/Notification.php';
require_once '../model/Child.php';


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


// Return the count as JSON response
header('Content-Type: application/json');
echo json_encode(['count' => $count]);

$children = [];
$children = $user->getChildren();
$schedules = [];

foreach($children as $child){
    $schedulesArray = $child->getSchedule();
    foreach($schedulesArray as $schedule){
        $schedules[] = $schedule;
    }
}

function createNotification($user_id, $child_id, $message, $title, $current_time) {
    $notification = new Notification();
    $notification->setUserID($user_id);
    $notification->setChildID($child_id);
    $notification->setMessage($message);
    $notification->setTitle($title);
    $notification->setDateIssued($current_time);
    $notification->setReadN(false);
    $notification->add();
}

$current_time = new DateTime(null, new DateTimeZone('Europe/Bucharest'));
$current_time = $current_time->format('Y-m-d H:i');
foreach($schedules as $schedule){
    // $schedule = json_encode($schedule);
    error_log(json_encode($schedule));
    $child = new Child();
    $child->load($schedule['child_ID']);
    
    $schedule_time = new DateTime($schedule['nextNotif'], new DateTimeZone('Europe/Bucharest'));
    $formatted_schedule_time = $schedule_time->format('Y-m-d H:i');

    $schedule_date = $schedule_time->format('Y-m-d');
    $schedule_hours = $schedule_time->format('H:i');
    error_log("schedule_date: " . $schedule_date);
    error_log("schedule_hours: " . $schedule_hours);

    if($formatted_schedule_time < $current_time){
        $message = 'It is time for ' . $child->getFirstname() . ' ' . $child->getLastname() . ' to ' . $schedule['message'];
        switch($schedule['recurrence']){
            case 'Daily':{
                $title = 'Daily reminder';
                break;}
            case 'Weekly':{
                $title = 'Weekly reminder';
                break;}
            case 'Monthly':{
                $title = 'Monthly reminder';
                break;}
            case 'Yearly':{
                $title = 'Yearly reminder';
                break;}
            default:{
                $title = 'Reminder';
                break;
            }
            }
        $s = new Schedule();
        $s->load($schedule['id']);
        $s->setTime($schedule_hours);
        $s->setDate($schedule_date);
        $s->setNextNotif();
        error_log("s: " . json_encode($s));
        $s->save();
        createNotification($user_id, $schedule['child_ID'], $message, $title, $current_time);
    }
    }
?>