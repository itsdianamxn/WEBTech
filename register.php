<?php

/*
$_POST['firstName']	Diana-Alexandra
$_POST['lastName']	Maxiniuc
$_POST['relationSelect']	Parent
$_POST['email']	dianalexandramaxiniuc@gmail.com
$_POST['dob']	no value
$_POST['password']	1111
$_POST['secondPassword']	1111
*/

// Database connection settings
$dbhost = 'localhost';  // or your host
$dbname = 'children';
$username = 'root';
$password = '';

// Create a new PDO instance
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);

// Set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare and bind
$stmt = $conn->prepare("SELECT 1 FROM users WHERE email = :email");
$stmt->bindParam(':email', htmlspecialchars($_POST['email']));

// Execute the prepared statement
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Email already exists. Try again.
    header("Location: register.html?error=alreadyExists");
    exit();
}

$stmt = $conn->prepare('INSERT INTO users (firstName, lastName, relationship, email, dob, password) ' . 
                                'VALUES (:firstName, :lastName, :relationship, :email, :dob, :password)');
$stmt->bindParam(':firstName', htmlspecialchars($_POST['firstName']));
$stmt->bindParam(':lastName', htmlspecialchars($_POST['lastName']));
$stmt->bindParam(':relationship', htmlspecialchars($_POST['relationSelect']));
$stmt->bindParam(':email', htmlspecialchars($_POST['email']));
$stmt->bindParam(':dob', htmlspecialchars($_POST['dob']));
$stmt->bindParam(':password', password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT));

if ($stmt->execute())
{
    // Redirect to login page
    header("Location: login.html");
}
else
{
    // Error
    header("Location: register.html?error=dbError");
}

// Close connection
$conn = null;
?>
