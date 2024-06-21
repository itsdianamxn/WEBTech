<?php
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];
require_once '../model/User.php';
$u = new User();
$u->load($userId);

$children = isset($_GET["children"]) ? htmlspecialchars($_GET["children"]) : "";

require_once "../model/Child.php";
require_once "../model/Picture.php";

$allPictures = [];

if ($children != "") {
    
    echo '<div class="name-title">';
    echo '<h2>Pictures of ';
    $first = true;

    $children = rtrim($children, ',');
    $childrenIds = explode(",", $children);
    foreach($childrenIds as $childId)
    {
        $c = new Child();
        $c->load($childId);
        $pictures = $c->getPictures();
        $allPictures = array_merge($allPictures, $pictures);

        if ($first) {
            $first = false;
        } else {
            echo ', ';
        }
        echo $c->getFirstname();
    }
    
    echo '</h2>';   
    echo '</div>';

    if (count($childrenIds) == 1) {
        
        echo '<form class="upload-form" action="../controller/uploadPhotoController.php" '.
                'method="post" enctype="multipart/form-data">';
        echo '<p>Select new file for upload:</p>';
        
        echo '<input type="hidden" name="childId" id="childId" value="' . $childrenIds[0] . '">';
        echo '<label for="fileToUpload" class="custom-file-upload">';
        echo 'Choose a file';
        echo '</label>';
        echo '<input type="file" name="fileToUpload" id="fileToUpload">';
        echo '<input type="submit" value="Upload" name="submit">';

        echo '</form>';
    }
    
    echo '<div class="">';
    $endl = "\n";
    foreach($allPictures as $picture) {
        $mediaFilePath = pathinfo($picture->getPicture(), PATHINFO_FILENAME);

        $title = ucwords(str_replace(['_', '-', '.', ','], ' ', $mediaFilePath));
        if (in_array(pathinfo($picture->getPicture(), PATHINFO_EXTENSION), array("mp4", "avi", "mov", "wmv"))) {
            echo '<span class="image-preview">' . $title;
            echo '<img class="image-preview-img" src="../pics/genericVideo.png" alt="' . $title . 
                '" onclick="loadVideo(\'' . $picture->getPicture() . '\', this.alt)"><br>';
            echo $picture->getDate();
            echo '</span>';
        } else {
            echo '<span class="image-preview">';
            echo '  <div class="nameContainer">' . $endl;
            echo '      <svg onclick="location.href=\'deletePhoto.php?ID=' . $picture->getID() . '\'" aria-hidden="true" focusable="false" data-prefix="fad"' . $endl;
            echo '          data-icon="square-xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="-200 -200 700 700"' . $endl;
            echo '          class="svg-inline--fa fa-square-xmark fa-w-14 fa-xs" width="3rem" height="3rem">' . $endl;
            echo '          <g class="fa-group">' . $endl;
            echo '              <path fill="currentColor"' . $endl;
            echo '                  d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"' . $endl;
            echo '                  class="fa-secondary"></path>' . $endl;
            echo '          </g>' . $endl;
            echo '      </svg>' . $endl;
            echo '      <svg onclick="location.href=\'../view/addToTimeline.php?ID=' . $picture ->getID() . '\'" aria-hidden="true" focusable="false" data-prefix="fad"' . $endl;
            echo '          data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="-30 -230 800 800"' . $endl;
            echo '          class="svg-inline--fa-regular fa-star fa-w-14 fa-xs" width="3rem" height="3rem">' . $endl;
            echo '          <g class="fa-group">' . $endl;
            echo '              <path fill="currentColor"' . $endl;
            echo '                  d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"
                                    class="fa-primary"></path>' . $endl;
            echo '          </g>' . $endl;
            echo '      </svg>' . $endl;
            echo '  </div>' . $endl;
            echo $title;
            echo '<img class="image-preview-img" src="' . $picture->getPicture() . '" alt="' . $title . '" onclick="loadHighResImage(this.src, this.alt)"><br>';
            echo $picture->getDate();
            echo '</span>';
        }
    }
    echo '</div>';
} else {
    echo 'Nothing to display.<br>Select at least a child to view photos.';
}

?>
