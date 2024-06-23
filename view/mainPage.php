<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">


<head>
    
 <meta charset="UTF-8">
    <title>Child Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mainPageStyles.css" type="text/css">
    <script src = "../scripts/notifsCountScript.js"></script>
</head>

<body class="mainPage">
    <nav class="north-navbar">
        <ul class="north-nav">
            <li class="north-nav-item">
                <a href="profile.php" target="mainFrame" class="profile-nav-link">
                    <span style="font-size: 160%;">Profile</span>
                    <img src="../pics/profiles/<?php 
                        if (file_exists('../pics/profiles/'.$_SESSION['id'].'.jpg'))
                        echo $_SESSION['id'];
                        else echo '0';
                    ?>.jpg" alt="Profile Picture" class="profile-picture">
                </a>
            </li>
        </ul>
    </nav>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="logo">
                <a class="nav-link no-animation">
                    <span class="link-text">Childcare Manager</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="angle-double-right"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                        class="svg-inline--fa fa-angle-double-right fa-w-14 fa-5x">
                        <g class="fa-group">
                            <path fill="currentColor"
                                d="M224 273L88.37 409a23.78 23.78 0 0 1-33.8 0L32 386.36a23.94 23.94 0 0 1 0-33.89l96.13-96.37L32 159.73a23.94 23.94 0 0 1 0-33.89l22.44-22.79a23.78 23.78 0 0 1 33.8 0L223.88 239a23.94 23.94 0 0 1 .1 34z"
                                class="fa-secondary"></path>
                            <path fill="currentColor"
                                d="M415.89 273L280.34 409a23.77 23.77 0 0 1-33.79 0L224 386.26a23.94 23.94 0 0 1 0-33.89L320.11 256l-96-96.47a23.94 23.94 0 0 1 0-33.89l22.52-22.59a23.77 23.77 0 0 1 33.79 0L416 239a24 24 0 0 1-.11 34z"
                                class="fa-primary"></path>
                        </g>
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="childrenMenu.php" target="mainFrame" class="nav-link">
                    <span class="link-text">Children</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="baby" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                        class="svg-inline--fa fa-baby fa-w-14 fa-5x">
                        <path fill="currentColor"
                            d="M152 88a72 72 0 1 1 144 0A72 72 0 1 1 152 88zM39.7 144.5c13-17.9 38-21.8 55.9-8.8L131.8 162c26.8 19.5 59.1 30 92.2 30s65.4-10.5 92.2-30l36.2-26.4c17.9-13 42.9-9 55.9 8.8s9 42.9-8.8 55.9l-36.2 26.4c-13.6 9.9-28.1 18.2-43.3 25V288H128V251.7c-15.2-6.7-29.7-15.1-43.3-25L48.5 200.3c-17.9-13-21.8-38-8.8-55.9zm89.8 184.8l60.6 53-26 37.2 24.3 24.3c15.6 15.6 15.6 40.9 0 56.6s-40.9 15.6-56.6 0l-48-48C70 438.6 68.1 417 79.2 401.1l50.2-71.8zm128.5 53l60.6-53 50.2 71.8c11.1 15.9 9.2 37.5-4.5 51.2l-48 48c-15.6 15.6-40.9 15.6-56.6 0s-15.6-40.9 0-56.6L284 419.4l-26-37.2z"
                            class="fa-secondary"></path>
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="media.php" target="mainFrame" class="nav-link">
                    <span class="link-text">Multimedia</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="camera-retro" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="svg-inline--fa fa-camera-retro fa-w-16 fa-5x">
                        <path fill="currentColor"
                            d="M220.6 121.2L271.1 96 448 96v96H333.2c-21.9-15.1-48.5-24-77.2-24s-55.2 8.9-77.2 24H64V128H192c9.9 0 19.7-2.3 28.6-6.8zM0 128V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H271.1c-9.9 0-19.7 2.3-28.6 6.8L192 64H160V48c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16l0 16C28.7 64 0 92.7 0 128zM168 304a88 88 0 1 1 176 0 88 88 0 1 1 -176 0z"
                            class="fa-secondary"></path>
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="timeline.php" target="mainFrame" class="nav-link">
                    <span class="link-text">Timeline</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="timeline" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 590 512"
                        class="svg-inline--fa fa-timeline fa-w-16 fa-5x">
                        <path fill="currentColor"
                            d="M128 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm32 97.3c28.3-12.3 48-40.5 48-73.3c0-44.2-35.8-80-80-80S48 51.8 48 96c0 32.8 19.7 61 48 73.3V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H288v54.7c-28.3 12.3-48 40.5-48 73.3c0 44.2 35.8 80 80 80s80-35.8 80-80c0-32.8-19.7-61-48-73.3V288H608c17.7 0 32-14.3 32-32s-14.3-32-32-32H544V169.3c28.3-12.3 48-40.5 48-73.3c0-44.2-35.8-80-80-80s-80 35.8-80 80c0 32.8 19.7 61 48 73.3V224H160V169.3zM488 96a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM320 392a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"
                            class="fa-secondary"></path>
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="notifications.php" target="mainFrame" class="nav-link">
                    <span class="link-text">Notifications</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="envelope" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="svg-inline--fa fa-envelope fa-w-14 fa-5x">
                        <path fill="currentColor"
                            d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"
                            class="fa-secondary"></path>
                    </svg>
                    <span id="notificationsCount" class="notifications-count"></span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../documentation.html" target="mainFrame" class="nav-link">
                    <span class="link-text">Documentation</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="fa-book" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="svg-inline--fa fa-book fa-w-14 fa-5x">
                        <path fill="currentColor"
                            d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"
                            class="fa-secondary"></path>
                    </svg>
                </a>
            </li>
            <li class="nav-item last">
                <a href="../welcomePage.php" class="nav-link">
                    <span class="link-text">Logout</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="door-open" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="svg-inline--fa fa-door-open fa-w-14 fa-5x">
                        <path fill="currentColor"
                            d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5V448H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H96 288h32V480 32zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128h96V480c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H512V128c0-35.3-28.7-64-64-64H352v64z"
                            class="fa-secondary"></path>
                    </svg>
                </a>
            </li>
        </ul>
    </nav>
    <main>
        <iframe src="childrenMenu.php" name="mainFrame" 
                style="width: 100%; height: 100%; border:none; overflow:hidden;"></iframe>
    </main>
</body>

</html>