<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/notifications.css">
</head>
    <body class="notifications-body">
        <h1 class="notif-title">Notifications</h1>
        <div class = "notifs">
            <ul class="notifications-list">
                <!-- <li class="notification">
                        
                        <p class="notification-text">
                            Andrea needs to eat!
                        </p>
                        <div class="new-notification-header">
                            <h3 class="notification-title">Time for dinner!</h3>
                            <p class="notification-time">1 hour ago</p>
                        </div>
                </li>

                <li class="notification">
                    
                    <p class="notification-text">It's 9:00 pm, Marius needs to be tucked in bed!</p>
                    <div class="new-notification-header">
                        <h3 class="notification-title">Sleep time!</h3>
                        <p class="notification-time">2 hours ago</p>
                    </div>
                </li>
                <li class="notification">
                    <p class="notification-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam nostrum sunt sapiente nisi ipsum voluptates eligendi, dignissimos similique, laborum numquam quam libero molestias rerum itaque doloremque, eum at dicta ex?</p>
                    <div class="old-notification-header">
                        <h3 class="notification-title">Old message</h3>
                        <p class="notification-time">2 days ago</p>
                    </div>
                </li> -->
                <?php require_once '../controller/notificationsController.php'; ?>
            </ul>
        </div>
    </body>
</html>