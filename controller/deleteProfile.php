<?php
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];
require_once "../model/User.php";
$u = new User();
$u->load($userId);
$u->delete();
//echo 'Success!';
session_destroy();
header("Location: ../view/login.html");
?>