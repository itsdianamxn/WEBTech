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
    require_once "../model/Child.php";
    $c = new Child();
    $c->load($id);
    $c->delete();
}

header("Location: ../view/manageChildren.php");

?>