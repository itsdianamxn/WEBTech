<?php

/*
$_POST['firstName']	Diana-Alexandra
$_POST['lastName']	Maxiniuc
$_POST['relationSelect']	Parent
$_POST['email']	dianalexandramaxiniuc@gmail.com
$_POST['dob']	no value
$_POST['password']	1111
$_POST['secondPassword']	1111
*/

require_once '../model/Database.php';
$db = new Database();
$result = $db->select("SELECT 1 FROM users WHERE email = :email", [':email'=> htmlspecialchars($_POST['email'])]);

if ($result) {
    // Email already exists. Try again.
    header("Location: ../view/register.html?error=alreadyExists");
    exit();
}
require_once '../model/User.php';
$user = new User();
$user->setFirstname(htmlspecialchars($_POST['firstName']));
$user->setLastname(htmlspecialchars($_POST['lastName']));
$user->setEmail(htmlspecialchars($_POST['email']));
$user->setPassword(htmlspecialchars($_POST['password']));
$user->setRelation(htmlspecialchars($_POST['relationSelect']));
$user->setDOB(htmlspecialchars($_POST['dob']));
$user->setPassword(password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT));

if ($user->save())
{
    // Redirect to login page
    header("Location: ../view/login.html");
}
else
{
    // Error
    header("Location: ../view/register.html?error=dbError");
}

// Close connection
$conn = null;
?>
