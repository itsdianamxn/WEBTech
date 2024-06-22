<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }  
    $userId = $_SESSION['id'];
    $type = $_GET['type'];
    $childId = $_GET['child'];

    require_once "../model/Child.php";
    $c = new Child();
    $c->load($childId);
?>   

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add/Modify Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registerStyle.css" type="text/css">
    <script language="javascript">
        function updateForm()
        {
            switch (document.getElementById("recurrence").value)
            {
                case "Daily":
                    document.getElementById("date").style.display = 'none';
                    document.getElementById("dow").style.display = 'none';
                    break;
                case "Weekly":
                    document.getElementById("date").style.display = 'none';
                    document.getElementById("dow").style.display = 'block';
                    break;
                case "One-time":
                case "Monthly":
                case "Yearly":
                    document.getElementById("date").style.display = 'block';
                    document.getElementById("dow").style.display = 'none';
                    break;
            }
        }
    </script>
</head>

<body class="register" onload="updateForm();">
    <div class="mainRegister">
        <h1 class="title">New <?php echo $type; ?> Schedule for <?php echo $c->getFirstname(); ?></h1>
        <div class="mainRegister">
            <form id="registerPage" action="../controller/eventController.php" method="post">
                <input type="hidden" id="childId" name="childId" value="<?php echo $childId; ?>">
                <input type="hidden" id="action" name="action" value="create">

                <div class="childRegisterInputs">
                    <div class="inputField" style="display:none;">
                        <label>Type</label>
                        <select name="evType" id="evType">
                            <option value="Feeding" <?php if ($type == "Feeding") echo "selected"; ?>>Feeding</option>
                            <option value="Sleep" <?php if ($type == "Sleep") echo "selected"; ?>>Sleep</option>
                            <option value="Medical" <?php if ($type == "Medical") echo "selected"; ?>>Medical</option>
                            <option value="Evolution" <?php if ($type == "Evolution") echo "selected"; ?>>Sleep</option>
                        </select>
                    </div>
                    <div class="inputField">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description">
                    </div>
                    <div class="inputField">
                        <label>Recurrence</label>
                        <select name="recurrence" id="recurrence" onChange="updateForm();">
                            <option value="One-time">One-time</option>
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>

                    <div class="inputField"> <!-- for all cases -->
                        <label>Time:</label>
                        <input type="time" id="time" name="time" value="09:00">
                    </div>

                    <div class="inputField" id="date"> <!-- not for 'Weekly'-->
                        <label>Date:</label>
                        <input type="date" name="date" value="<?php
                            $d = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
                            echo date('Y-m-d', $d);
                         ?>">
                    </div>

                    <div class="inputField" id="dow"> <!-- only for Weekly -->
                        <label>Day of Week</label>
                        <select name="dow">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="7">Sunday</option>
                        </select>
                    </div>
                </div>

                <div class="inputField" id="expiration">
                    <label>Expiry Date:</label>
                    <input type="date" name="expiration">
                </div>

                <div id="buttons">
                    <div class="regButton ">
                        <button type="submit" id="reg">Save</a>
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