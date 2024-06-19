<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimedia for <?php echo htmlspecialchars($_GET["children"]); ?></title>
    <link rel="stylesheet" href="../css/childrenPhotos.css">
    <?php
    require_once "../controller/childPhotosController.php";
    ?>
</head>
<body>
    

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
