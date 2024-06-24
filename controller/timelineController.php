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

$childrenIds = isset($_GET["children"]) ? htmlspecialchars($_GET["children"]) : "";
$pictures = [];
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <link rel='stylesheet' href='../css/timelinePhotoStyles.css' type='text/css'>
    <script src='../scripts/timelineScript.js'></script>
</head>
<body>

<?php
    if ($childrenIds == "") {
        echo "<div class = \"no-events\">";
        echo "<p>No child selected.</p> <p>Please, select a child in order to display your favorite memories of them!</p>";
        echo "</div>";
    } else {
        $childrenIds = rtrim($childrenIds, ',');
        $children = explode(",", $childrenIds);
        $pictures = [];
        $pictureObj = new Picture();

        $appName = urlencode ("Child Care Manager");
        $appBaseline = "www.child-care-manager.com";
        $shareUrlAll = urlencode($appBaseline ."/timeline?children=" . $childrenIds);

        echo "<div class=\"timelines\">";
        foreach ($children as $childId) {
            $child = new Child();
            $child->load($childId);
            $childPictures = $pictureObj->getTimelineOfChild($childId); // Get pictures for the current child
            $shareUrlChild = urlencode($appBaseline ."/timeline?children=" . $child->getID());

            if (empty($childPictures)) {
                echo "No pictures found for " . $child->getFirstame() . ".";
            } else {
                echo "<h2 class = \"name-container\">" . $child->getFirstName() . " " . $child->getLastName() . "</h2>";
                echo "<div class=\"timelineContainer\">";
                foreach ($childPictures as $pic) {
                    $shareUrlPic = $appBaseline. "/" . $pic->getPicture();
                    $facebookShare = "https://www.facebook.com/sharer.php?u=" . $shareUrlAll;
                    $xShare = "https://twitter.com/intent/tweet?text=" . urlencode($pic->getDescription()) . "&amp;url=" . $shareUrlPic . "&amp;via=" .$appName;
                    $pinterestShare = "https://pinterest.com/pin/create/button/?url=" . $shareUrlPic . 
                            "&amp;media=" . $shareUrlPic .
                            "&amp;description=" . urlencode($pic->getDescription());
                    $whatsappShare = "https://api.whatsapp.com/send?text=" . urlencode($pic->getDescription()) . " %0A%0A " . $shareUrlPic;
                
                    echo "<div class=\"timelineEvent\">\n";
                    echo "      <strong>" . $pic->getDate() . "</strong><br>";
                    echo "      <div class = \"img-description\">" . $pic->getDescription() . "</div><br />\n";
                    
                    //     echo '          <svg class="fa-solid fa-share-from-square" alt="Share" onclick="share()">
                    //          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M352 224H305.5c-45 0-81.5 36.5-81.5 81.5c0 22.3 10.3 34.3 19.2 40.5c6.8 4.7 12.8 12 12.8 20.3c0 9.8-8 17.8-17.8 17.8h-2.5c-2.4 0-4.8-.4-7.1-1.4C210.8 374.8 128 333.4 128 240c0-79.5 64.5-144 144-144h80V34.7C352 15.5 367.5 0 386.7 0c8.6 0 16.8 3.2 23.2 8.9L548.1 133.3c7.6 6.8 11.9 16.5 11.9 26.7s-4.3 19.9-11.9 26.7l-139 125.1c-5.9 5.3-13.5 8.2-21.4 8.2H384c-17.7 0-32-14.3-32-32V224zM80 96c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16H400c8.8 0 16-7.2 16-16V384c0-17.7 14.3-32 32-32s32 14.3 32 32v48c0 44.2-35.8 80-80 80H80c-44.2 0-80-35.8-80-80V112C0 67.8 35.8 32 80 32h48c17.7 0 32 14.3 32 32s-14.3 32-32 32H80z"/></svg>
                    //      </svg><br>';                    
                    echo "      <img src='" . $pic->getPicture() . "'></img>\n";
                    echo "<p>Share with: ";
                    echo        ' <a href="' . $facebookShare . '"> <svg style="width:1rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></a> ' . "\n";
                    echo        ' <a href="' . $xShare . '"><svg style="width:1rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg></a> ' . "\n";
                    echo        ' <a href="' . $pinterestShare . '"><svg style="width:1rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3 .8-3.4 5-20.3 6.9-28.1 .6-2.5 .3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/></svg></a> ' . "\n";
                    echo        ' <a href="' . $whatsappShare . '"><svg style="width:1rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a> ' . "\n";
                    echo "</p></div>\n";
                }
                echo "</div>";
            }
        }
        echo "</div>";
    }
?>
</body>
</html>

    