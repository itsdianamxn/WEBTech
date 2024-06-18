<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimedia for <?php echo htmlspecialchars($_GET["children"]); ?></title>
    <link rel="stylesheet" href="../css/childrenPhotos.css">
</head>
<body>
    <?php
        session_start();
        if (!array_key_exists('id', $_SESSION)) {
            header("Location: ../view/login.html");
            exit();
        }
        $userId = $_SESSION['id'];
        $children = isset($_GET["children"]) ? htmlspecialchars($_GET["children"]) : "";

        if ($children != "") {
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

                if (count($childrenIds) == 1) {
                    echo '<form action="../controller/uploadPhotoController.php" method="post" enctype="multipart/form-data">';
                    echo 'Select new file for upload:';
                    echo '<input type="hidden" name="childId" id="childId" value="' . $childrenIds[0] . '">';
                    echo '<input type="file" name="fileToUpload" id="fileToUpload">';
                    echo '<input type="submit" value="Upload" name="submit">';
                    echo '</form>';
                }

                $stmt = $conn->prepare("SELECT * FROM images WHERE child_ID in ($in)");
                $stmt->execute($childrenIds);
                while ($result = $stmt->fetch()) {
                    $title = ucwords(str_replace(['_', '-', '.', ','], ' ', pathinfo($result['Picture'], PATHINFO_FILENAME)));
                    echo '<span class="image-preview">' . $title . '<br>';
                    echo '<img class="image-preview-img" src="' . $result['Picture'] . '" alt="' . $title . '" onclick="loadHighResImage(this.src, this.alt)"><br>';
                    echo $result['uploadDate'];
                    echo '</span>';
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo 'Nothing to display.<br>Select at least a child to view photos.';
        }
    ?>

    <div></div>

    <script>
        function loadHighResImage(imgSrc, title) {
            var highResImg = document.getElementById("hires-img");
            if (highResImg == null) {
                highResImg = document.createElement("img");
                highResImg.id = "hires-img";
                highResImg.style.position = "fixed";
                highResImg.style.top = "50%";
                highResImg.style.left = "50%";
                highResImg.style.transform = "translate(-50%, -50%)";
                highResImg.style.maxWidth = "100%";
                highResImg.style.maxHeight = "100%";
                document.body.appendChild(highResImg);
                highResImg.onclick = function() {
                    document.body.removeChild(highResImg);
                };
            }
            highResImg.src = imgSrc;
            highResImg.alt = title;
        }
    </script>
</body>
</html>
