<?php
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Child Manager!</title>
    <link rel="stylesheet" href="./css/welcomePageStyle.css" type="text/css">
</head>

<body class="welcome">
    <div class="register-page">
        <h1 class="title">Welcome to<br> Child Manager!</h1>
        <div class="buttons-container">
            <form class="welcomePage" action="controller/welcomePage.php" method="post">

                <div class="welcomeButtons">
                    <a href="view/login.html" class="login" id="login">
                        <h1>Login</h1>
                    </a>
                    <a href="view/register.html" class="register-first-page" id="register-first">
                        <h1>Register</h1>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>