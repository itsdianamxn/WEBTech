<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION))) {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    if (!(array_key_exists('type', $_GET)) || !(array_key_exists('child', $_GET))) {
        return;
    }

    $type = $_GET['type'];
    $childId = $_GET['child'];

    require_once "../model/Child.php";
    $child = new Child();
    $child->load($childId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta charset="utf-8">
    <title><?php echo $type; ?> Schedule</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/calendar.css" type="text/css">
    <!-- <script src="../scripts/scheduleScript.js"></script> -->
    <script>var onetimeEvents = [];</script>
</head>

<body>
    <div class="container">
        <form method="post" id="deleteForm" action="../controller/eventController.php" style="display:none;">
            <input type="hidden" name="childId" value="<?php echo $childId; ?>">
            <input type="hidden" name="evType" value="<?php echo $type; ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="scheduleID" id="scheduleID" value="0">
        </form>

        <div class="logs-header">
            <h1><?php echo $type; ?> Schedule</h1>
        </div>
        <div class="logs-body">
            <button class="add-button" 
                onclick="location.href='addEvent.php?action=create&type=<?php echo $type; ?>&child=<?php echo $childId; ?>'">
                Add New <?php echo $type; ?> Schedule
            </button>
            <?php
                $schedules = $child->getSchedules($type);
                $endl = "\n";
                foreach ($schedules as $schedule) {
                    echo '   <div class="logs-day">' . $endl;
                    echo '     <div class="logs-day-header">' . $endl;
                    echo '       <h3>' . $schedule->getMessage() . '</h3>' . $endl;
                     if ($schedule->isTimeline())
                     {
                        echo '      <svg aria-hidden="true" focusable="false" data-prefix="fad"' . $endl;
                        echo '          data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 550 550"' . $endl;
                        echo '          class="svg-inline--fa-regular fa-star fa-w-14 fa-xs" width="2rem" height="2rem">' . $endl;
                        echo '          <g class="fa-group">' . $endl;
                        echo '              <path fill="yellow"' . $endl;
                        echo '                  d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"
                                                class="fa-primary"></path>' . $endl;
                        echo '          </g>' . $endl;
                        echo '      </svg>' . $endl;      
                    }
                    else {
                        echo '      <svg onclick="addToTimeline(' . $schedule ->getID() . ')" aria-hidden="true" focusable="false" data-prefix="fad"' . $endl;
                        echo '          data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 550 550"' . $endl;
                        echo '          class="svg-inline--fa-regular fa-star fa-w-14 fa-xs" width="2rem" height="2rem">' . $endl;
                        echo '          <g class="fa-group">' . $endl;
                        echo '              <path fill="currentColor"' . $endl;
                        echo '                  d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"
                                                class="fa-primary"></path>' . $endl;
                        echo '          </g>' . $endl;
                        echo '      </svg>' . $endl;                    
                    }
                    echo '     </div>' . $endl;
                    echo '       <ul>' . $endl;
                    echo '           <li>Recurrence: ' . $schedule->getRecurrence() . '</li>' . $endl;
                    switch ($schedule->getRecurrence()) {
                        case 'Daily':
                            echo '           <li>Time: ' . $schedule->getTime()  . '</li>' . $endl;
                            break;
                        case 'Weekly':
                            echo '           <li>Time: Monday, time ' . $schedule->getTime()  . '</li>' . $endl;
                            break;
                        case 'Monthly':
                            $date = date_create($schedule->getDate());
                            echo '           <li>Date: ' . date_format($date, 'd') . ', time: ' .
                                $schedule->getTime()  . '</li>' . $endl;
                            break;
                        case 'Yearly':
                            $date = date_create($schedule->getDate());
                            echo '           <li>Date: ' . date_format($date, 'd-M') . ', time: ' .
                                $schedule->getTime()  . '</li>' . $endl;
                            break;
                        case "One-time":
                            $date = date_create($schedule->getDate());
                            echo '           <li>Date: ' . date_format($date, 'd-M') . ', time: ' .
                                $schedule->getTime()  . '</li>' . $endl;
                            echo "<script>onetimeEvents.push('" . date_format($date, 'Y-m-d') . "')</script>\n";
                            break;
                    }

                    if ($schedule->getRecurrence() != "One-time")
                    {
                        if ($schedule->getExpiration())
                            echo '           <li>Expires: ' . $schedule->getExpiration() . '</li>' . $endl;
                        else
                            echo '           <li><i>No expiration</i></li>' . $endl;
                    }

                    echo '       </ul>' . $endl;
                    echo '       <div><a href="../view/addEvent.php?action=edit&type='. $type .
                        '&child='.  $childId . '&scheduleID=' . $schedule->getId() . '">Modify</a> - ' .
                        '<a href="#" onclick="deleteSchedule(' . $schedule->getId() . ', \'' . $schedule->getType() . '\');">Delete</a></div>' . $endl;
                    echo '   </div>' . $endl . $endl;
                }
            ?>
        </div>
    </div>

    <div id="calendar-container">
        <div id="calendar-header">
            <button id="prev-month">&lt;</button>
            <h2 id="month-year"></h2>
            <button id="next-month">&gt;</button>
        </div>
        <table id="calendar">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody id="calendar-body">
            </tbody>
        </table>
    </div>
    <script src="../scripts/scheduleScript.js"></script>
</body>

</html>
