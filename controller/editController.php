<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
    

    require_once '../model/User.php';
    $u = new User();
    $u->load($userId);
    $u->setFirstname(htmlspecialchars($_POST['firstName']));
    $u->setLastname(htmlspecialchars($_POST['lastName']));
    $u->setRelation(htmlspecialchars($_POST['relationSelect']));
    $u->setDOB(htmlspecialchars($_POST['dob']));
    $u->setPassword(password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT));

    
    if ($u->save())
    {
        echo "Profile updated successfully!";
        header("Location: ../view/profile.php");
    }
    else
    {
        // Error
        header("Location: ../view/profile.html?error=dbError");
    }
?>