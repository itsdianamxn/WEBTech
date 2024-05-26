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

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $childID = $_GET['ID'];
    try {
        // Prepare an SQL statement
        $stmt = $conn->prepare("SELECT firstname, lastname, dob, stage FROM children WHERE id=?");
        // Bind parameters and execute the prepared statement
        $stmt->execute([$childID]);
        if ($result = $stmt->fetch())
        {
            $firstname = $result['firstname'];
            $lastname = $result['lastname'];
            $dob = $result['dob'];
            $stage = $result['stage'];
        }
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
    <title>Edit Child</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registerStyle.css" type="text/css">
</head>

<body class="register">
    <div class="mainRegister">
        <form action="updateChildPhoto.php"  method="post" enctype="multipart/form-data">

        <img class="child-photo" src="pics/childrenProfiles/<?php
                        if (file_exists('pics/childrenProfiles/'.$childID.'.jpg'))
                            echo $childID;
                        else echo '0';
                        ?>.jpg" alt="Child picture">
            <h2>Change profile picture:</h2>
            <input type="hidden" name="childId" id="childId" value= "<?php echo $childID; ?>"> 

            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload" name="submit">
        </form>
        <div class="mainRegister">
            <form id="registerPage" action="editChildController.php" method="post">
                <div class="childRegisterInputs">
                    <div class="inputField childInputField">
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo $firstname; ?>" required>

                    </div>
                    <div class="inputField childInputField">
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo $lastname; ?>">
                    </div>
                    <div class="inputField childInputField">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>">
                    </div>
                    <div class="inputField childInputField">
                        <label>Learning stage</label>
                        <select name="stageSelect" >
                            <option value="NewBorn" <?php if ($stage == 'NewBorn') echo 'selected' ?>>NewBorn</option>
                            <option value="Infant" <?php if ($stage == 'Infant') echo 'selected' ?>>Infant</option>
                            <option value="Toddler" <?php if ($stage == 'Toddler') echo 'selected' ?>>Toddler</option>
                            <option value="Preschooler" <?php if ($stage == 'Preschooler') echo 'selected' ?>>Preschooler</option>
                            <option value="In Primary school" <?php if ($stage == 'In Primary school') echo 'selected' ?>> In Primary school</option>
                            <option value="Tween" <?php if ($stage == 'Tween') echo 'selected' ?>>Tween</option>
                        </select>
                    </div>
                </div>
                <div class="regButton childRegButton">
                    <button id="reg" onclick="window.location.href='manageChildren.php'">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>