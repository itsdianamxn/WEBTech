<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION))) {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
    $childID = $_GET['ID'];

    require_once "../model/Child.php";
    $child = new Child();
    $child->load($childID);
    $firstname = $child->getFirstname();
    $lastname = $child->getLastname();
    $dob = $child->getDOB();
    $stage = $child->getStage();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta charset="UTF-8"> 
    <title>Edit Child</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registerStyle.css" type="text/css">
</head>
<body class="register">
    <div class="mainRegister">
        <img class="child-photo" src="../pics/childrenProfiles/<?php
            if (file_exists('../pics/childrenProfiles/'.$childID.'.jpg'))
                echo $childID;
            else
                echo '0';
        ?>.jpg" alt="Child picture">
        <h2>Change profile picture:</h2>
        <form action="../controller/updateChildPhoto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="childId" id="childId" value="<?php echo $childID; ?>"> 
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload" name="submit">
        </form>
        <div class="mainRegister">
            <form id="registerPage" action="../controller/editChildController.php" method="post">
                <div class="childRegisterInputs">
                    <input type="hidden" name="childId" id="childId" value="<?php echo $childID; ?>"> 
                    <div class="inputField childInputField">
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstname); ?>" required>
                    </div>
                    <div class="inputField childInputField">
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastname); ?>">
                    </div>
                    <div class="inputField childInputField">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                    </div>
                    <div class="inputField childInputField">
                        <label>Learning stage</label>
                        <select name="stageSelect">
                            <option value="NewBorn" <?php if ($stage == 'NewBorn') echo 'selected'; ?>>NewBorn</option>
                            <option value="Infant" <?php if ($stage == 'Infant') echo 'selected'; ?>>Infant</option>
                            <option value="Toddler" <?php if ($stage == 'Toddler') echo 'selected'; ?>>Toddler</option>
                            <option value="Preschooler" <?php if ($stage == 'Preschooler') echo 'selected'; ?>>Preschooler</option>
                            <option value="In Primary school" <?php if ($stage == 'In Primary school') echo 'selected'; ?>>In Primary school</option>
                            <option value="Tween" <?php if ($stage == 'Tween') echo 'selected'; ?>>Tween</option>
                        </select>
                    </div>
                </div>
                <div id="buttons">
                    <button id="reg"    type="submit">Save</button>
                    <button id="cancel" type="ignore" onclick="window.history.back();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
