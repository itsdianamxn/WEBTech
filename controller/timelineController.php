<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

$userId = $_SESSION['id'];

require_once '../model/User.php';
require_once '../model/Child.php';
require_once '../model/Picture.php';

$user = new User();
$user->load($userId);

$children = isset($_GET["children"]) ? htmlspecialchars($_GET["children"]) : "";
$pictures = [];


echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
echo "<title>Timeline</title>";
echo "<link rel='stylesheet' href='../css/timelinePhotoStyles.css' type='text/css'>";
echo "</head>";
echo "<body>";

if ($children == "") {
    echo "<div class = \"no-events\">";
    echo "No child selected. Please, select a child in order to display your favorite memories of them!";
    echo "</div>";
} else {
        $children = rtrim($children, ',');
        $children = explode(",", $children);
        $pictures = [];
        $pictureObj = new Picture(); // Instantiate the Picture object outside the loop
        echo "<div class=\"timelines\">";
        foreach ($children as $childId) {
            $child = new Child();
            $child->load($childId);
            $childPictures = $pictureObj->getTimelineOfChild($childId); // Get pictures for the current child

            if (empty($childPictures)) {
                echo "No pictures found for " . htmlspecialchars($child->getLastName()) . ".";
            } else {
                echo "<h2>" . htmlspecialchars($child->getFirstName()) . " " . htmlspecialchars($child->getLastName()) . "</h2>";
                echo "<div class=\"timelineContainer\">";
                foreach ($childPictures as $pic) {
                    echo "<div class=\"timelineEvent\">\n";
                    echo "<strong>" . htmlspecialchars($pic->getDate()) . "</strong><br />\n";
                    echo "<div class = \"img-description\">" . htmlspecialchars($pic->getDescription()) . "</div><br />\n";
                    echo "<img height=\"200px\" src='" . htmlspecialchars($pic->getPicture()) . "'></img>\n";
                    echo "</div>\n";
                }
                echo "</div>";
            }
        }
        echo "</div>";
    }
echo "</body>";
echo "</html>";
?>
