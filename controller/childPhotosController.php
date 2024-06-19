<?php
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];

$children = isset($_GET["children"]) ? htmlspecialchars($_GET["children"]) : "";

require_once "../model/Child.php";
require_once "../model/Picture.php";
require_once "../model/Database.php";

$database = new Database();

if ($children != "") {
    $children = rtrim($children, ',');
    $childrenIds = explode(",", $children);

    try {
        $dbhost = $database->getDbhost();
        $dbname = $database->getDbname();
        $dbusername = $database->getDbusername();
        $dbpassword = '';
        $conn = $database->getConnection();

        $in = str_repeat('?,', count($childrenIds) - 1) . '?';
        $child = new Child();
        $stmt = $conn->prepare("SELECT * FROM children WHERE ID in ($in)");
        $stmt->execute($childrenIds);

        $childrenData = [];
        while ($result = $stmt->fetch()) {
            $childrenData[] = $result['firstname'];
        }

        $stmt = $conn->prepare("SELECT * FROM images WHERE child_ID in ($in)");
        $stmt->execute($childrenIds);

        $imagesData = [];
        while ($result = $stmt->fetch()) {
            $title = ucwords(str_replace(['_', '-', '.', ','], ' ', pathinfo($result['Picture'], PATHINFO_FILENAME)));
            $imagesData[] = [
                'title' => $title,
                'src' => $result['Picture'],
                'uploadDate' => $result['uploadDate']
            ];
        }
        // if(count($childrenData) > 0 && count($imagesData) > 0)
        //     echo json_encode(['children' => $childrenData, 'images' => $imagesData]);

    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} 
if ($children != "") {
            echo '<div class="name-title">';
            echo '<h2>Pictures of ';
            $children = rtrim($children, ',');
            $childrenIds = explode(",", $children);

            try {
                $dbhost = 'localhost';
                $dbname = 'children';
                $dbusername = 'root';
                $dbpassword = '';
                $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $in = str_repeat('?,', count($childrenIds) - 1) . '?';
                $stmt = $conn->prepare("SELECT * FROM children WHERE ID in ($in)");
                $stmt->execute($childrenIds);

                $first = true;
                while ($result = $stmt->fetch()) {
                    if ($first) {
                        $first = false;
                    } else {
                        echo ', ';
                    }
                    echo $result['firstname'];
                }
                echo '</h2>';   
                echo '</div>';
                if (count($childrenIds) == 1) {
                    
                    echo '<form class="upload-form" action="../controller/uploadPhotoController.php" method="post" enctype="multipart/form-data">';
                    echo '<p>Select new file for upload:</p>';
                    
                    echo '<input type="hidden" name="childId" id="childId" value="' . $childrenIds[0] . '">';
                    echo '<label for="fileToUpload" class="custom-file-upload">';
                    echo 'Choose a file';
                    echo '</label>';
                    echo '<input type="file" name="fileToUpload" id="fileToUpload">';
                    echo '<input type="submit" value="Upload" name="submit">';

                    echo '</form>';
                }
                

                $stmt = $conn->prepare("SELECT * FROM images WHERE child_ID in ($in)");
                $stmt->execute($childrenIds);
                echo '<div class="photos-container">';
                while ($result = $stmt->fetch()) {
    
                    $title = ucwords(str_replace(['_', '-', '.', ','], ' ', pathinfo($result['Picture'], PATHINFO_FILENAME)));
                    echo '<span class="image-preview">';
                    echo '<img class="image-preview-img" src="' . $result['Picture'] . '" alt="' . $title . '" onclick="loadHighResImage(this.src, this.alt)"><br>';
                    echo $result['uploadDate'];
                    echo '</span>';
                    
                }
                echo '</div>';
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo 'Nothing to display.<br>Select at least a child to view photos.';
        }
?>
