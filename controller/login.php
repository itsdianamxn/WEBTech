<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();

require_once '../model/User.php';

// Check if the cookie is set and log in the user automatically
if (isset($_COOKIE['user'])) {
    error_log("Cookie set");
    $u = new User();
    if ($u->find($_COOKIE['user'])) {
        $_SESSION['id'] = $u->getId();
        $_SESSION['firstname'] = $u->getFirstname();
        $_SESSION['lastname'] = $u->getLastname();
        $_SESSION['email'] = $u->getEmail();
        header("Location: ../view/mainPage.php");
        exit();
    }
}

$email = htmlspecialchars($_POST['email']);
$user_password = htmlspecialchars($_POST['password']);

$u = new User();
if ($u->find($email)) {
    if (password_verify($user_password, $u->getPassword())) {
        // Start the session and set session variables
        $_SESSION['id'] = $u->getId();
        $_SESSION['firstname'] = $u->getFirstname();
        $_SESSION['lastname'] = $u->getLastname();
        $_SESSION['email'] = $u->getEmail();

        // Set a cookie for 30 days
        setcookie('user', $email, time() + (86400 * 30), "/");
        error_log("Cookie set name: " . $_COOKIE['user']);
        // Redirect to the main page
        header("Location: ../view/mainPage.php");
        exit();
    } else {
        // Invalid email/password combination
        header("Location: ../view/login.html?msg=badCredentials/pwd");
        exit();
    }
} else {
    // Invalid email/password combination
    header("Location: ../view/login.html?msg=badCredentials/usr");
    exit();
}
?>
