<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    /*
    $_POST['firstName']	Daniel
    $_POST['lastName']	Lazurca
    $_POST['dob']	2024-05-07
    $_POST['stageSelect']	In Primary school
    */

    require_once '../model/Child.php';
        
    $c = new Child();
    $c->setFirstname(htmlspecialchars($_POST['firstName']));
    $c->setLastname(htmlspecialchars($_POST['lastName']));
    $c->setDOB(htmlspecialchars($_POST['dob']));
    $c->setStage(htmlspecialchars($_POST['stageSelect']));
    $c->setParentID($userId);


    if ($c->add())
    {
        // Redirect all children list
        header("Location: ../view/manageChildren.php?success=1");
    }
    else
    {
        // Error
        header("Location: ../view/registerChild.php?error=1");
    }
?>
