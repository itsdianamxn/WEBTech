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
$current_time = new DateTime(null, new DateTimeZone('Europe/Bucharest'));
$current_hour = $current_time->format('H');
$current_minute = $current_time->format('i');
$current_day = $current_time->format('N');
$current_month = $current_time->format('m');
$current_date = $current_time->format('d');
foreach($schedules as $schedule){
    // $schedule = json_encode($schedule);
    list($hour, $minute) = explode(':', $schedule['time']);
    $schedule_time = new DateTime($schedule['time'], new DateTimeZone('Europe/Bucharest'));
    $schedule_day = $schedule_time->format('N');
    $schedule_month = $schedule_time->format('m');
    $schedule_date = $schedule_time->format('d');
    if($current_hour == $hour && $current_minute == $minute){
        switch($schedule['recurrence']){
            case 'Daily':
                {
                    $notification = new Notification();
                    $notification->setUserID($user_id);
                    $notification->setChildID($schedule['child_ID']);
                    $notification->setMessage('Time to ' . $schedule['message']);
                    $notification->setTitle('Daily reminder');
                    $notification->setDateIssued($current_time->format('Y-m-d H:i:s'));
                    $notification->setRead(false);
                    $notification->add();
                }
                break;
            case 'Weekly':
                {
                    if($current_day == $schedule_day){
                        $notification = new Notification();
                        $notification->setUserID($user_id);
                        $notification->setChildID($schedule['child_ID']);
                        $notification->setMessage('Time to ' . $schedule['message']);
                        $notification->setTitle('Weekly reminder');
                        $notification->setDateIssued($current_time->format('Y-m-d H:i:s'));
                        $notification->setRead(false);
                        $notification->add();
                    }
                }
                break;
            case 'Monthly':
                {
                    if($current_date == $schedule_date){
                        $notification = new Notification();
                        $notification->setUserID($user_id);
                        $notification->setChildID($schedule['child_ID']);
                        $notification->setMessage('Time to ' . $schedule['message']);
                        $notification->setTitle('Monthly reminder');
                        $notification->setDateIssued($current_time->format('Y-m-d H:i:s'));
                        $notification->setRead(false);
                        $notification->add();
                    }
                    break;
                }
            case 'Yearly':
                {
                    if($current_date == $schedule_date && $current_month == $schedule_month){
                        $notification = new Notification();
                        $notification->setUserID($user_id);
                        $notification->setChildID($schedule['child_ID']);
                        $notification->setMessage('Time to ' . $schedule['message']);
                        $notification->setTitle('Yearly reminder');
                        $notification->setDateIssued($current_time->format('Y-m-d H:i:s'));
                        $notification->setRead(false);
                        $notification->add();
                    }
                }
            default:
                break;
        }
    }
}


?>