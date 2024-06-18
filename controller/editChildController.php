<?php
session_start();
if (!(array_key_exists('id', $_SESSION))) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];

if (isset($_POST['childId'])) {
    $child_id = $_POST['childId'];
} else {
    header("Location: ../view/editChild.php?error=missingChildId");
    exit();
}
require_once '../model/Child.php';
$c = new Child();
$c->load($child_id);
$c->setFirstname(htmlspecialchars($_POST['firstName']));
$c->setLastname(htmlspecialchars($_POST['lastName']));
$c->setDOB(htmlspecialchars($_POST['dob']));
$c->setStage(htmlspecialchars($_POST['stageSelect']));
$c->setParentID($userId);

if ($c->save())
{
    echo "Child profile updated successfully!";
    header("Location: ../view/manageChildren.php?success=1");
}
else
{
    // Error
    header("Location: ../view/editChild.php?error=dbError");
    exit();
}
?>
