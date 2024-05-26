<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: login.html");
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
    <meta charset="UTF-8">
    <title>Manage</title>
    <link rel="stylesheet" href="css/manageStyles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="whole-page">
    <div class="container">
        <?php
            $endl = "\n";
            while ($result = $stmt->fetch())
            {
                $firstname = $result['firstname'];
                $lastname = $result['lastname'];
                $dob = $result['dob'];
                $ID = $result['ID'];

                echo '<div class="child-thumbnail" id="child-'. $ID .'">' . $endl;
                echo '  <div class="nameContainer">' . $endl;
                echo '      <svg onclick="location.href=\'deleteChild.php?ID=' . $ID . '\'" aria-hidden="true" focusable="false" data-prefix="fad"' . $endl;
                echo '          data-icon="square-xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="-200 -200 700 700"' . $endl;
                echo '          class="svg-inline--fa fa-square-xmark fa-w-14 fa-xs" width="3rem" height="3rem">' . $endl;
                echo '          <g class="fa-group">' . $endl;
                echo '              <path fill="currentColor"' . $endl;
                echo '                  d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"' . $endl;
                echo '                  class="fa-secondary"></path>' . $endl;
                echo '          </g>' . $endl;
                echo '      </svg>' . $endl;
                echo '      <span class="child-name">' . $firstname . '</span>' . $endl;
                echo '      <svg onclick="location.href=\'editChild.php?ID=' . $ID . '\'" aria-hidden="true" focusable="false" data-prefix="fad"' . $endl;
                echo '          data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="-30 -230 800 800"' . $endl;
                echo '          class="svg-inline--fa fa-pen-to-square fa-w-14 fa-xs" width="3rem" height="3rem">' . $endl;
                echo '          <g class="fa-group">' . $endl;
                echo '              <path fill="currentColor"' . $endl;
                echo '                  d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"' . $endl;
                echo '                  class="fa-primary"></path>' . $endl;
                echo '          </g>' . $endl;
                echo '      </svg>' . $endl;
                echo '  </div>' . $endl;
                echo '  <ul class="supplementary-info">' . $endl;
                echo '      <li class="info">'. $lastname .'</li>' . $endl;
                echo '      <li class="info">Age: ' . date_diff(date_create($dob), date_create(date("Y-m-d")))->format('%y') . '</li>' . $endl;
                echo '      <li class="info">Birthdate: ' . $dob . '</li>' . $endl;
                echo '  </ul>' . $endl;
                echo '  <img src="pics/childrenProfiles/'; 
                    if (file_exists('pics/childrenProfiles/'.$ID.'.jpg'))
                        echo $ID;
                    else echo '0';
                echo '.jpg" alt="Child picture">' . $endl;
                echo '</div>' . $endl;
            }
        ?>
    </div>
    <div class="button-container">
        <button class="add-button" onclick="location.href='registerChild.php'"> ADD </button>
        <button class="exit-button" onclick="location.href='profile.php'">EXIT</button>
    </div>
    </div>

</body>

</html>