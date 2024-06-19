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
    
    $endl = "\n";
    if ($children == null)
            {
                //echo 'no children';
            }
    else
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

?>