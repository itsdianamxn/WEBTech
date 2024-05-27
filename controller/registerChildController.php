<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    /*
    $_POST['firstName']	Daniel
    $_POST['lastName']	Lazurca
    $_POST['dob']	2024-05-07
    $_POST['stageSelect']	In Primary school
    */

    // Database connection settings
    $dbhost = 'localhost';  // or your host
    $dbname = 'children';
    $dbusername = 'root';
    $password = '';

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('INSERT INTO children (firstname, lastname, dob, stage, parent_ID) ' . 
                                    'VALUES (:firstname, :lastname, :dob, :stage, :parent_ID)');
    $stmt->bindParam(':firstname', htmlspecialchars($_POST['firstName']));
    $stmt->bindParam(':lastname', htmlspecialchars($_POST['lastName']));
    $stmt->bindParam(':dob', htmlspecialchars($_POST['dob']));
    $stmt->bindParam(':stage', htmlspecialchars($_POST['stageSelect']));
    $stmt->bindParam(':parent_ID', $userId);

    if ($stmt->execute())
    {
        // Redirect all children list
        header("Location: ../view/manageChildren.php?success=1");
    }
    else
    {
        // Error
        header("Location: ../view/registerChild.php?error=1");
    }

    // Close connection
    $conn = null;
?>
