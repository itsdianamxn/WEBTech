<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: login.html");
        exit();
    }
    $userId = $_SESSION['id'];
    
    // Database connection settings
    $dbhost = 'localhost';  // or your host
    $dbname = 'children';
    $dbusername = 'root';
    $dbpassword = '';

    /*
    $_POST['firstName']	Diana-Alexandra
    $_POST['lastName']	Maxiniuc
    $_POST['relationSelect']	Parent
    $_POST['email']	dianalexandramaxiniuc@gmail.com
    $_POST['dob']	no value
    $_POST['password']	1111
    $_POST['secondPassword']	1111
    */

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the user ID from the session or another source
    $userId = $_SESSION['id'];

    try {
        // Prepare an SQL statement
        $stmt = $conn->prepare("UPDATE users SET firstName = ?, lastName = ?, relationship = ?, dob = ?, password = ? WHERE id = ?");
        // Bind parameters
        $stmt->execute([$_POST['firstName'], $_POST['lastName'], $_POST['relationSelect'], 
                        $_POST['dob'], password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT), $userId]);

        echo "Profile updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
?>