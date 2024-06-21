<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
    require_once "../model/User.php";

    $user = new User();
    $user->load($userId);
    $children = $user->getChildren();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Children</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/children.css" type="text/css">
    <script src="../controller/mediaScript.js"></script>

</head>

<body>
    <div class="body-container">
        <div class="container" id="all-children">
        <?php
            $endl = "\n";
            foreach($children as $child)
            {
                echo '<div class="child-thumbnail" id="child-'. $child->getID() .'">' . $endl;
                echo '<input type="checkbox" id="' . $child->getID() . '-checkbox" name="' . $child->getID() . '-checkbox" style="display: none;">' . $endl;
                echo '<span class="child-name">'. $child->getFirstname() . '</span><br>' . $endl;
                echo '  <img class=profile src="../pics/childrenProfiles/'; 
                    if (file_exists('../pics/childrenProfiles/'.$child->getID().'.jpg'))
                        echo $child->getID();
                    else echo '0';
                echo '.jpg" alt="Child picture">' . $endl;
        
                echo '<div class="dropdown">'. $endl;
                echo '<a href="food-calendar.html" target="calendarFrame">Food</a>' . $endl;
                echo '<a href="sleep-calendar.html" target="calendarFrame">Sleep</a>' . $endl;
                echo '<a href="health-calendar.html" target="calendarFrame">Health</a>' . $endl;
                echo '<a href="evolution-calendar.html" target="calendarFrame">Evolution</a>' . $endl;
                echo '<a href="groups.html" target="calendarFrame">Groups</a>' . $endl;
                echo '</div>' . $endl;
                echo '</div>' . $endl;
            } 
        ?>
        </div>
        <div class="calendar-container">
            <iframe name="calendarFrame" src="food-calendar.html"
                style="height: 100%; width: 100%; border: none;"></iframe>
        </div>
    </div>
</body>

</html>