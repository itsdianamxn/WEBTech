<?php
session_start();
if (!(array_key_exists('id', $_SESSION))) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];

if (isset($_POST['childId'])) {
    $child_id = $_POST['childId'];
} else {
    header("Location: ../view/editChild.php?error=missingChildId");
    exit();
}

// Database connection settings
$dbhost = 'localhost';  // or your host
$dbname = 'children';
$dbusername = 'root';
$password = '';

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement for updating the children table
    $stmt = $conn->prepare('UPDATE children 
                            SET firstname = :firstname, 
                                lastname = :lastname, 
                                dob = :dob, 
                                stage = :stage 
                            WHERE ID = :child_id');
    
    // Get the POST values and sanitize them
    $firstname = htmlspecialchars($_POST['firstName']);
    $lastname = htmlspecialchars($_POST['lastName']);
    $dob = htmlspecialchars($_POST['dob']);
    $stage = htmlspecialchars($_POST['stageSelect']);
    
    // Bind the parameters to the statement
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':stage', $stage);
    $stmt->bindParam(':child_id', $child_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to all children list
        header("Location: ../view/manageChildren.php?success=1");
    } else {
        // Error
        header("Location: ../view/editChild.php?error=executionFailed");
    }
} catch (PDOException $e) {
    // Error handling
    header("Location: ../view/editChild.php?error=" . $e->getMessage());
    exit();
}

// Close connection
$conn = null;
?>
