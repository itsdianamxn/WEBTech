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

if ($children == "") {
    echo "No children selected.";
} else {
    $children = rtrim($children, ',');
    $children = explode(",", $children);

    foreach ($children as $childId) {
        $child = new Child();
        $child->load($childId);
        $pictures = array_merge($pictures, $child->getPictures(true));
    }

    if (empty($pictures)) {
        echo "No events.";
    } else {
        echo "<div class = \"timelineContainer\">";
        foreach ($pictures as $pic) {
            echo "<div class=\"timelineEvent\">\n";
            echo "<strong>" . htmlspecialchars($pic->getDate()) . "</strong><br />\n";
            echo "<i>" . htmlspecialchars($pic->getDescription()) . "</i><br />\n";
            echo "<img height=\"200px\" src='" . htmlspecialchars($pic->getPicture()) . "'></img>\n";
            echo "</div><hr />\n";
        }
        echo "</div>";
    }
}
?>
