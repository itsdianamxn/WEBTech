<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }  
    $userId = $_SESSION['id'];
    
    require_once '../model/User.php';
    $u = new User();
    $user = $u->load($userId);
?>   

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta charset="UTF-8">
    <title>Register Child</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registerStyle.css" type="text/css">
</head>

<body class="register">
    <div class="mainRegister">
        <h1 class="title">Add a new child to the family.</h1>
        <div class="mainRegister2">
            <form id="registerPage" action="../controller/registerChildController.php" method="post">
                <div class="childRegisterInputs">
                    <div class="inputField childInputField">
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName" required>
                    </div>
                    <div class="inputField childInputField">
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo $u->getLastName(); ?>">
                    </div>
                    <div class="inputField childInputField">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="inputField childInputField">
                        <label>Learning stage</label>
                        <select name="stageSelect">
                            <option value="NewBorn">NewBorn</option>
                            <option value="Infant">Infant</option>
                            <option value="Toddler">Toddler</option>
                            <option value="Preschooler">Preschooler</option>
                            <option value="In Primary school"> In Primary school</option>
                            <option value="Tween">Tween</option>
                        </select>
                    </div>
                </div>
                <div id="buttons">
                    <button id="reg"    type="submit">Register</button>
                    <button id="cancel" type="button" onclick="window.history.back();">Cancel</button>                    
                </div>
            </form>
        </div>
    </div>
</body>

</html>