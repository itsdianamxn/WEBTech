<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "children";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, relationship=?, email=?, dob=?, password=? WHERE user_id=?");
$stmt->bind_param("ssssssi", $firstName, $lastName, $relationship, $email, $dob, $hashedPassword, $userId);

// Validate and set parameters
$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);
$relationship = htmlspecialchars($_POST['relationSelect']);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$dob = $_POST['dob']; // Consider validating the date format
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
} else {
    die("User not logged in.");
}

// Execute the statement
if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
