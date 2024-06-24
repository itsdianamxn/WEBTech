<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    require_once '../model/User.php';
    require_once '../model/Child.php';

    $u = new User();
    $u->load($userId);
    $children = $u->getChildren();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
        <meta charset="UTF-8">
        <title>Timeline</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/timelineStyles.css" type="text/css">
        <script src="../scripts/timelineScript.js" defer></script>
    </head>
    <body onload="refreshIframe()">
        <div class="container" id="all-children">
        <?php
                $endl = "\n";
                if ($children == null)
                {
                    echo '<p>No children registered</p>' . 
                         '<p>Use <i>Profile | Manage Children</i> to add new children.</p>';
                }
                else {
                    foreach ($children as $child) {
                        echo '      <div class="child-thumbnail" id="child-'.$child->getID().'" onclick="updatePictures('.$child->getID().')">' . $endl;
                        echo '      <input type="checkbox" id="'.$child->getID().'-checkbox" name="'.$child->getID().'-checkbox"  style="display: none;">' . $endl;
                        echo '      <span class="child-name">'.$child->getFirstname().'</span><br>' . $endl;
                        echo '      <img class="child-photo" src="../pics/childrenProfiles/'; 
                        if (file_exists('../pics/childrenProfiles/'.$child->getID().'.jpg'))
                            echo $child->getID();
                        else echo '0';
                            echo '.jpg" alt="Child picture">' . $endl;
                        echo '      </div>' . $endl;
                    }
                }
            ?>
        </div>
        <iframe class="files" id="webpage-iframe"></iframe>
    </body>
</html>
