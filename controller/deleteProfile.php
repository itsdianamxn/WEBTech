<?php
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];
require_once "../model/User.php";
$u = new Child();
$u->load($userId);
$u->delete();

header("Location: ../view/profile.php");
?>