
<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: login.html");
        exit();
    }
    $userId = $_SESSION['id'];
    $firstname = "unknown";
    $lastname = "unknown";
    $relationship = "unknown";
    $email = "unknown";
    $dob = "unknown";

    // Database connection settings
    $dbhost = 'localhost';  // or your host
    $dbname = 'children';
    $dbusername = 'root';
    $dbpassword = '';

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Prepare an SQL statement
        $stmt = $conn->prepare("SELECT firstName, lastName, relationship, email, dob FROM users WHERE id=?");
        // Bind parameters and execute the prepared statement
        $stmt->execute([$userId]);
        if ($result = $stmt->fetch())
        {
            $firstname = $result['firstName'];
            $lastname = $result['lastName'];
            $relationship = $result['relationship'];
            $email = $result['email'];
            $dob = $result['dob'];
        }
        // echo $result['firstName'], $result['lastName'], $result['relationship'], $result['email'], $result['dob'];

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv=”Pragma” content=”no-cache”>
    <meta http-equiv=”Expires” content=”-1″>
    <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
    <meta charset="UTF-8">
    <title>Edit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editStyle.css" type="text/css">
</head>

<body class="edit">
    <div style="display: flex; justify-content: flex-start; align-items: center;width: 100%; height: 100%;">
        <div class="mainedit">
            <h1 class="title">Edit your profile.</h1>

            <form id="editPage" action="edit.php" method="post">
                <div class="inputField">
                    <label style="display: flex; align-items: center;" for="firstName">First name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo  $firstname; ?>" required>

                </div>
                <div class="inputField">
                    <label style="display: flex; align-items: center;" for="lastName">Last name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo  $lastname; ?>">
                </div>
                <div class="inputField">
                    <label style="display: flex; align-items: center;">Relationship to children</label>
                    <select name="relationSelect">
                        <option value="Parent" <?php if ($relationship == 'Parent') echo 'selected' ?>>Parent</option>
                        <option value="Grandparent" <?php if ( $relationship == 'Grandparent') echo 'selected' ?>>Grandparent</option>
                        <option value="Guardian" <?php if ($relationship == 'Legal Guardian') echo 'selected' ?>>Legal Guardian</option>
                    </select>
                </div>
                <div class="inputField">
                    <label for="email" style="display: flex; align-items: center;">Email</label>
                    <input type="email" disabled id="email" name="email" value="<?php echo  $email; ?>">
                </div>
                <div class="inputField">
                    <label for="dob" style="display: flex; align-items: center;">Your date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo  $dob; ?>">
                </div>
                <div class="inputField">
                    <label for="password" style="display: flex; align-items: center;">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="inputField">
                    <label for="secondPassword" style="display: flex; align-items: center;">Repeat Password</label>
                    <input type="password" id="secondPassword" name="secondPassword">
                </div>
                <div class="buttonDiv">
                    <button type="submit" id="reg">Save</button>
                </div>
            </form>
        </div>

    </div>
</body>

</html>
