<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }  
?>   

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Child</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registerStyle.css" type="text/css">
</head>

<body class="register">
    <div class="mainRegister">
        <h1 class="title">Add a new child to the family.</h1>
        <div class="mainRegister">
            <form id="registerPage" action="../controller/registerChildController.php" method="post">
                <div class="childRegisterInputs">
                    <div class="inputField childInputField">
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName">
                    </div>
                    <div class="inputField childInputField">
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" name="lastName">
                    </div>
                    <div class="inputField childInputField">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob">
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
                    <div class="regButton ">
                        <!-- <button type="submit" id="reg">Register</a> -->
                        <a class=" Cancel" onclick="document.getElementById('registerPage').submit()" id="reg">Register</a> 
                    </div>
                    <div class="regButton">
                        <a class=" Cancel" onclick="history.go(-1)" id="cancel">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>