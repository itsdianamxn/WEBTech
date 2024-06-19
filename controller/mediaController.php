<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    require_once '../model/User.php';
    require_once '../model/Child.php';

    $u = new User();
    $u->load($userId);
    $children = $u->getChildren();
?>