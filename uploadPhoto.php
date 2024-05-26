<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    $target_dir = "pics/";
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

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>\n";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>\n";

            // insert into database

            // Database connection settings
            $dbhost = 'localhost';  // or your host
            $dbname = 'children';
            $dbusername = 'root';
            $dbpassword = '';

            // Create a new PDO instance
            $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare('INSERT INTO images (child_ID, Picture) VALUES (:child_ID, :Picture)');
            $stmt->bindParam(':child_ID', htmlspecialchars($_POST['childId']));
            $stmt->bindParam(':Picture', $target_file);

            if ($stmt->execute())
            {
                header("Location: childrenPhotos.php?children=". htmlspecialchars($_POST['childId']));
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
    echo 'Click <a href="childrenPhotos.php?children=' . htmlspecialchars($_POST['childId']) . '">here</a> to go back to current pictures.';
?>