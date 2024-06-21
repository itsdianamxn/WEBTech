<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
    $picture = $_GET['ID'];
    $desc = htmlspecialchars($_GET['msg']);

    require_once '../model/Picture.php';

    $p = new Picture();
    $p->load($picture);
    $p->addToTimeline($desc);
    $p->save();
    header("Location: ../view/timeline.php");

?>