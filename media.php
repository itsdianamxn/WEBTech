<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    // Database connection settings
    $dbhost = 'localhost';
    $dbname = 'children';
    $dbusername = 'root';
    $dbpassword = '';

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Prepare an SQL statement
        $stmt = $conn->prepare("SELECT * FROM children WHERE parent_ID=?");
        // Bind parameters and execute the prepared statement
        $stmt->execute([$userId]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Multimedia</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/mediaStyle.css">
      <script>
        function refreshIframe() {
            var webpageUrl = "childrenPhotos.php?children=";

            var childrenNode = document.getElementById("all-children");
            for (var i = 0; i < childrenNode.children.length; i++) {
                if (!childrenNode.children[i].id.startsWith("child-")) {
                    continue;
                }
                var id = childrenNode.children[i].id.substring("child-".length);
                // Do something with each child element
                var check = document.getElementById(id+"-checkbox");
                var thumb = document.getElementById("child-" + id);
                thumb.style.backgroundColor = check.checked ? "#9ccfff99" : "#ffcc9c73";
                if (check.checked) 
                    webpageUrl += id + ",";
            }

            // Get a reference to the iframe element
            var iframe = document.getElementById("webpage-iframe");

            // Set the src property of the iframe to the URL of the webpage
            iframe.src = webpageUrl;
        }
        function updatePictures(clickChild)
        {
            var check = document.getElementById(clickChild+"-checkbox");
            check.checked = !check.checked;
            refreshIframe();
        }
    </script>
    </head>
    <body onload="refreshIframe()">
        <div class="container" id="all-children">
            <?php
                $endl = "\n";
                while ($result = $stmt->fetch())
                {
                    $firstname = $result['firstname'];
                    $lastname = $result['lastname'];
                    $dob = $result['dob'];
                    $ID = $result['ID'];

                    echo '      <div class="child-thumbnail" id="child-'.$ID.'" onclick="updatePictures('.$ID.')">' . $endl;
                    echo '      <input type="checkbox" id="'.$ID.'-checkbox" name="'.$ID.'-checkbox"  style="display: none;">' . $endl;
                    echo '      <span class="child-name">'.$firstname.'</span><br>' . $endl;
                    echo '      <img class="child-photo" src="pics/childrenProfiles/'; 
                        if (file_exists('pics/childrenProfiles/'.$ID.'.jpg'))
                            echo $ID;
                        else echo '0';
                    echo '.jpg" alt="Child picture">' . $endl;
                    echo '      </div>' . $endl;
                }
            ?>
        </div>
        <iframe class = "files" id="webpage-iframe" style="width: 80%; height: 80%;"></iframe>
    </body>
</html>