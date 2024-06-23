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
    $action = isset($_GET['action']) ? $_GET['action'] : 'create'; // default is create
    $isEdit = $action == 'edit';

    require_once "../model/Child.php";
    $c = new Child();
    $c->load($childId);

    require_once "../model/Schedule.php";
    $event = new Schedule();
    if ($isEdit)
        $event->load($_GET['scheduleID']);
?>   

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $isEdit ? 'Modify' : 'Create New'; ?> Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/editEvent.css" type="text/css">
    <script src="../scripts/eventScript.js"></script>
</head>

<body class="register" onload="updateForm();">
    <div class="mainRegister">
        <h1 class="title"><?php echo ($isEdit ? 'Modify ' : 'Create New ') . $type;
             ?> Schedule for <?php echo $c->getFirstname(); ?></h1>
        <div class="mainRegister">
            <form id="registerPage" action="../controller/eventController.php" method="post">
                <input type="hidden" id="childId" name="childId" value="<?php echo $childId; ?>">
                <input type="hidden" id="eventId" name="eventId" value="<?php echo $event->getId(); ?>">
                <input type="hidden" id="action" name="action" value="<?php echo $action; ?>">

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
                        <input type="text" id="description" name="description" value="<?php echo $event->getMessage(); ?>" required>
                    </div>
                    <div class="inputField">
                        <label>Recurrence</label>
                        <select name="recurrence" id="recurrence" onChange="updateForm();">
                            <option value="One-time" <?php if ($event->getRecurrence() == "One-time") echo "selected"; ?>>One-time</option>
                            <option value="Daily" <?php if ($event->getRecurrence() == "Daily") echo "selected"; ?>>Daily</option>
                            <option value="Weekly" <?php if ($event->getRecurrence() == "Weekly") echo "selected"; ?>>Weekly</option>
                            <option value="Monthly" <?php if ($event->getRecurrence() == "Monthly") echo "selected"; ?>>Monthly</option>
                            <option value="Yearly" <?php if ($event->getRecurrence() == "Yearly") echo "selected"; ?>>Yearly</option>
                        </select>
                    </div>

                    <div class="inputField"> <!-- for all cases -->
                        <label>Time:</label>
                        <input type="time" id="time" name="time" value="<?php echo $event->getTime(); ?>">
                    </div>

                    <div class="inputField" id="date"> <!-- not for 'Weekly'-->
                        <label>Date:</label>
                        <input type="date" name="date" value="<?php echo $event->getDate(); ?>">
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
                    <input type="date" name="expiration" value="<?php echo $event->getExpiration(); ?>">
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