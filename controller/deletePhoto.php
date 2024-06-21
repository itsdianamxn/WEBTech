<?php
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];

if (isset($_GET["ID"]) )
{
    $id = htmlspecialchars($_GET["ID"]);
    require_once "../model/Picture.php";
    $p = new Picture();
    $p->load($id);
    $p->delete();
}

header("Location: ../view/media.php");
?>