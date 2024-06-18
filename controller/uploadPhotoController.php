<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    $target_dir = "../pics/";
    $target_file = $target_dir . $_FILES["fileToUpload"]["name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".<br>\n";
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>\n";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    $i = 0;
    $target_file_tmp = $target_file;
    while (file_exists($target_file_tmp)) {
        $target_file_tmp = substr($target_file, 0, strlen($target_file) - 1 - strlen($imageFileType)) . '(' . $i . ').' . $imageFileType;
        $i++;
    }
    $target_file = $target_file_tmp;

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Your file is too large. Your file is " . $_FILES["fileToUpload"]["size"] . " bytes.<br>\n";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Only JPG, JPEG, PNG & GIF files are allowed. Your file is a ". $imageFileType . "<br>\n";
        $uploadOk = 0;
    }
    $child_id = htmlspecialchars($_POST['childId']);

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>\n";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>\n";
    
            require_once '../model/Picture.php';
        
            $p = new Picture();
            $p->setChildID($child_id);
            $p->setPicture($target_file);

            if ($p->add())
            {
                header("Location: ../view/childrenPhotos.php?children=" . $child_id);
                exit();
            }
            else
            {
                // Error
                echo "Sorry, your file was not inserted into database.<br>\n";
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>\n";
        }
    }
    echo 'Click <a href="childrenPhotos.php?children=' . $child_id . '">here</a> to go back to current pictures.';
?>