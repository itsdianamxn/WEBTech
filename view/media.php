<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta charset="UTF-8">
    <title>Multimedia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mediaStyle.css">
    <script src = "../scripts/mediaScript.js"></script>
</head>
    <body onload="refreshIframe()">
        <div class="container" id="all-children">
            <?php require_once "../controller/mediaController.php"; ?>
        </div>
        <iframe class="files" id="webpage-iframe"></iframe>
    </body>
</html>