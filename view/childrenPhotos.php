<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    $children = "";
    if (isset($_GET["children"])){
        $children =  htmlspecialchars($_GET["children"]);
        if (str_ends_with($children, ","))
        {
            $children = substr($children, 0, strlen($children) - 1);
        }
    }
    $childrenIds = explode(",", $children); // transform from string to array
    $endl = "\n";

    // Database connection settings
    $dbhost = 'localhost';
    $dbname = 'children';
    $dbusername = 'root';
    $dbpassword = '';

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html lang="en">

    <head>  
    <title>Multimedia for <?php echo $children; ?></title>
      <link rel="stylesheet" href="../css/childrenPhotos.css">
    </head>
    <body>
        

        <?php 
            if ($children != "")
            {
                echo '<h2>Pictures of ';
                try {
                    // Prepare an SQL statement
                    $in  = str_repeat('?,', count($childrenIds) - 1) . '?';
                    $stmt = $conn->prepare("SELECT * FROM children WHERE ID in ($in)");
                    // Bind parameters and execute the prepared statement
                    $stmt->execute($childrenIds);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                $first = true;
                while ($result = $stmt->fetch())
                {
                    if ($first)
                    {
                        $first = false;
                    }
                    else
                    {
                        echo ', ';
                    }
                    echo $result['firstname'];
                }
                echo '</h2>';
            }
            else
            {
                echo 'Nothing to display.<br>Select at least a child to view photos.';
                exit();
            }

            if ($children != "" && count($childrenIds) == 1) {
                echo '  <form action="../controller/uploadPhotoController.php"  method="post" enctype="multipart/form-data">' . $endl;
                echo '    Select new file for upload:' . $endl;
                echo '    <input type="hidden" name="childId" id="childId" value="' . $childrenIds[0] . '">' . $endl;
                echo '    <input type="file" name="fileToUpload" id="fileToUpload">' . $endl;
                echo '    <input type="submit" value="Upload" name="submit">' . $endl;
                echo '  </form>' . $endl;
            } 
        ?>

        <div>
            <?php
                    try {
                        // Prepare an SQL statement
                        $in  = str_repeat('?,', count($childrenIds) - 1) . '?';
                        $stmt = $conn->prepare("SELECT * FROM images WHERE child_ID in ($in)");
                        // Bind parameters and execute the prepared statement
                        $stmt->execute($childrenIds);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    while ($result = $stmt->fetch())
                    {
                        $title = substr($result['Picture'], strlen("../pics/"));
                        $dot = strrpos($title, '.');
                        $title = ucwords(str_replace(['_', '-', '.', ','], ' ', substr($title, 0, $dot)));
                        echo '    <span class="image-preview">' . $title . '<br>' . $endl;
                        echo '        <img class="image-preview-img" src="' . $result['Picture'] . '" alt="' . $title . '" onclick="loadHighResImage(this.src, this.alt)">' . $endl;
                        echo '        <br>' . $result['uploadDate'] . $endl;
                        echo '    </span>' . $endl;
                    }

                    // Close connection
                    $conn = null;

            ?>
        </div>
        <script>
            function loadHighResImage(imgSrc, title) {
                var highResImg = document.getElementById("hires-img");
                if (highResImg == null)
                {
                    highResImg = document.createElement("img");
                    highResImg.id="hires-img";

                    // Set the style of the high-res image to be centered and have a max-width of 100%
                    highResImg.style.position = "fixed";
                    highResImg.style.top = "50%";
                    highResImg.style.left = "50%";
                    highResImg.style.transform = "translate(-50%, -50%)";
                    highResImg.style.maxWidth = "100%";
                    highResImg.style.maxHeight = "100%";

                    // Append the high-res image to the body of the HTML document
                    document.body.appendChild(highResImg);

                    // Remove the high-res image when it is clicked
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