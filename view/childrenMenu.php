<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    // Database connection settings
    $dbhost = 'localhost';
    $dbname = 'children';
    $dbusername = 'root';
    $dbpassword = '';

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Prepare an SQL statement
        $stmt = $conn->prepare("SELECT * FROM children WHERE parent_ID=?");
        // Bind parameters and execute the prepared statement
        $stmt->execute([$userId]);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">    <meta charset="UTF-8">
    <title>Children</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/children.css" type="text/css">
</head>

<body onload="refreshIframe()">
    <div class="body-container">
        <div class="container" id="all-children">
        <?php
            $endl = "\n";
            while ($result = $stmt->fetch())
            {
                $firstname = $result['firstname'];
                $lastname = $result['lastname'];
                $dob = $result['dob'];
                $ID = $result['ID'];
                echo '<div class="child-thumbnail" id="child-'. $ID .'">' . $endl;
                echo '<input type="checkbox" id="' . $ID . '-checkbox" name="' . $ID . '-checkbox" style="display: none;">' . $endl;
                echo '<span class="child-name">'. $firstname . '</span><br>' . $endl;
                echo '  <img class=profile src="../pics/childrenProfiles/'; 
                    if (file_exists('../pics/childrenProfiles/'.$ID.'.jpg'))
                        echo $ID;
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