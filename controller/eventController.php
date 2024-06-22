<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    $action = $_POST['action'];
    $childId = $_POST['childId'];
    $type = $_POST['evType'];

    require_once '../model/Schedule.php';
        //echo "'$action' new $recurrence $type schedule for child $childId with description $description";
    
    if ($action == 'create')
    {
        $schedule = new Schedule();
        $schedule->setChildId($childId);
        $schedule->setType($type);
        $schedule->setMessage(htmlspecialchars($_POST['description']));
        $schedule->setRecurrence($_POST['recurrence']);
        $schedule->setExpiration($_POST['expiration']);
        $schedule->setTime($_POST['time']);
        $schedule->setDate($_POST['date']);
        $schedule->add();
    }

    if ($action == 'delete')
    {
        $schedule = new Schedule();
        $schedule->load($_POST['scheduleID']);
        $schedule->delete();
    }

    header("Location: ../view/schedule.php?type=$type&child=$childId");
?>