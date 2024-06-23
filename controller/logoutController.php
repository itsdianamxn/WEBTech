<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Delete the 'user' cookie by setting its expiration time to a past time
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/'); // '/' ensures the cookie is deleted across the whole domain
}

// Redirect to the welcome page after logout
header("Location: ../view/login.html");
exit();
?>