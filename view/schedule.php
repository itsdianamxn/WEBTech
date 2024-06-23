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
    <script src="../scripts/scheduleScript.js"></script>
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
                    echo '       <p>SVG icon here</p>' . $endl;
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
                    }

                    if ($schedule->getExpiration())
                        echo '           <li>Expires: ' . $schedule->getExpiration() . '</li>' . $endl;
                    else
                        echo '           <li><i>No expiration</i></li>' . $endl;

                    echo '       </ul>' . $endl;
                    echo '       <div><a href="../view/addEvent.php?action=edit&type='. $type .
                        '&child='.  $childId . '&scheduleID=' . $schedule->getId() . '">Modify</a> - ' .
                        '<a href="#" onclick="deleteSchedule(' . $schedule->getId() . ');">Delete</a></div>' . $endl;
                    echo '   </div>' . $endl . $endl;
                }
            ?>
        </div>
    </div>

    <div class="calendar">
        <h2 class="center-text">
            April 2024
        </h2>

        <table class="calendar-table">
            <thead>
                <tr>
                    <th class="dow-style">Sun</th>
                    <th class="dow-style">Mon</th>
                    <th class="dow-style">Tue</th>
                    <th class="dow-style">Wed</th>
                    <th class="dow-style">Thu</th>
                    <th class="dow-style">Fri</th>
                    <th class="dow-style">Sat</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="faded">31</td>                    
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td>20</td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                    <td>26</td>
                    <td>27</td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>29</td>
                    <td>30</td>
                    <td class="faded">1</td>
                    <td class="faded">2</td>
                    <td class="faded">3</td>
                    <td class="faded">4</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
