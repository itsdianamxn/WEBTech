<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: login.html");
        exit();
    }
    $userId = $_SESSION['id'];

    $children = "";
    if (isset($_GET["children"]))
        $children =  htmlspecialchars($_GET["children"]);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Multimedia for <?php echo $children; ?></title>
      <link rel="stylesheet" href="css/childrenPhotos.css">
    </head>
    <body>
        <h2>Pictures of <?php echo $children; ?></h2>

        <form action="updateChildPhoto.php"  method="post" enctype="multipart/form-data">
            Select new file for upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload" name="submit">
        </form>

        <div>
            <span class="image-preview">
                Picture Title 1<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview">
                Picture Title 2<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
            
            <span class="image-preview"
                >

                Picture Title<br>
                <img src="pics/seaside_T.jpg" alt="Seaside" onclick="loadHighResImage(this)">
                <br>
                08 Aug 2022
            </span>
        </div>
        <script>
            function loadHighResImage(imgElement) {
                var highResImg = document.createElement("img");
                highResImg.src = "pics/seaside.jpg";

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
                highResImg.alt="Seaside" 
                highResImg.onclick = function() {
                    document.body.removeChild(highResImg);
                };
            }
        </script>
    </body>
</html>