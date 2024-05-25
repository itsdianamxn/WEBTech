<?php

/*
$_POST['email']	dianalexandramaxiniuc@gmail.com
$_POST['password']	1111
*/

$email=htmlspecialchars($_POST['email']);
$user_password=htmlspecialchars($_POST['password']);

// Database connection settings
$dbhost = 'localhost';  // or your host
$dbname = 'children';
$username = 'root';
$dbpassword = '';

// Create a new PDO instance
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $dbpassword);

// Set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);     

// Execute the prepared statement
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
//    echo $user_password, "\n", password_hash($user_password, PASSWORD_DEFAULT), "\n", $result['password'];
    if (password_verify($user_password, $result['password'])) {
        header("Location: mainPage.php");
        session_start();

        $_SESSION['id'] = $result['ID'];
        $_SESSION['firstname'] = $result['firstName'];
        $_SESSION['lastname'] = $result['lastName'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['phone'] = "07" . rand(0, 90000) . '0'. $_SESSION['id'];
    } else {
        // Invalid email/password combination!
        header("Location: login.html?msg=badCredentials/pwd");
    }
} else {
    // Invalid email/password combination!
    header("Location: login.html?msg=badCredentials/usr");
}

// Close connection
$conn = null;
?>
