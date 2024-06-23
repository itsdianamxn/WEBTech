<?php
// Set error handling
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/../errors.log'); // Use __DIR__ to ensure the path is correct

session_start();

require_once __DIR__ . '/../model/User.php'; // Ensure the correct path to the User model
error_log("Welcome Page Controller started");

// Check if the cookie is set and log in the user automatically
if (isset($_COOKIE['user'])) {
    error_log("Cookie 'user' is set");
    $u = new User();
    if ($u->find($_COOKIE['user'])) {
        error_log("User found: " . $_COOKIE['user']);
        
        // Set session variables
        $_SESSION['id'] = $u->getId();
        $_SESSION['firstname'] = $u->getFirstname();
        $_SESSION['lastname'] = $u->getLastname();
        $_SESSION['email'] = $u->getEmail();
        
        // Redirect to the main page
        header("Location: /WEBTech/view/mainPage.php");
        exit();
    } else {
        error_log("User not found for email: " . $_COOKIE['user']);
    }
} else {
    error_log("Cookie 'user' is not set");
}

// Redirect to the welcome page if no cookie is set or user not found
header("Location: view/login.html");
exit();
?>
