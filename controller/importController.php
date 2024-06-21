<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

require_once '../model/User.php';

$user = new User();
$user->load($_SESSION['id']);

header('Content-Type: application/json');


?>
