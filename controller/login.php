<?php
$email=htmlspecialchars($_POST['email']);
$user_password=htmlspecialchars($_POST['password']);

require_once '../model/User.php';
$u = new User();
if ($u->find($email))
    if (password_verify($user_password, $u->getPassword())) {
        header("Location: ../view/mainPage.php");
        session_start();

        $_SESSION['id'] = $u->getId();
        $_SESSION['firstname'] = $u->getFirstname();
        $_SESSION['lastname'] = $u->getLastname();
        $_SESSION['email'] = $u->getEmail();
        // $_SESSION['phone'] = "07" . rand(0, 90000) . '0'. $_SESSION['id'];
    } else {
        // Invalid email/password combination!
        header("Location: ../view/login.html?msg=badCredentials/pwd");
    }
 else {
    // Invalid email/password combination!
    header("Location: ../view/login.html?msg=badCredentials/usr");
}

?>
