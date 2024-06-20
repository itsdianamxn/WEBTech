<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimedia for <?php echo htmlspecialchars($_GET["children"]); ?></title>
    <link rel="stylesheet" href="../css/childrenPhotos.css">
    <script src="../controller/childrenPhotosScript.js"></script>

    
</head>
<body>
    <?php
    require_once "../controller/childPhotosController.php";
    ?>
</body>
</html>
