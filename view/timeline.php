<?php
    session_start();
    if (!array_key_exists('id', $_SESSION)) {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Timeline</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/timelineStyles.css" type="text/css">
    </head>
    <body>
        <?php
            require_once '../model/User.php';
            require_once '../model/Child.php';
            require_once '../model/Picture.php';
            $user = new User();
            $user->load($userId);
            $children = $user->getChildren();
            $pictures = [];
            foreach ($children as $child) {
                $pictures = array_merge($pictures, $child->getPictures(true));
            }
            foreach ($pictures as $pic)
            {
                echo "   <div class=\"timelineEvent\">\n";
                echo "      <strong>" . $pic->getDate() . "</strong><br />\n";
                echo "      <i>" . $pic->getDescription() . "</i><br />\n";
                echo "      <img height=\"200px\" src='" . $pic->getPicture() . "'></img>\n";
                echo "   </div><hr />\n";
            }
            if ($pictures == [])
                echo "No events.";
        ?>
    </body>
</html>