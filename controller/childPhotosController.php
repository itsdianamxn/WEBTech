<?php
session_start();
if (!array_key_exists('id', $_SESSION)) {
    header("Location: ../view/login.html");
    exit();
}
$userId = $_SESSION['id'];

$children = isset($_GET["children"]) ? htmlspecialchars($_GET["children"]) : "";

if ($children != "") {
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

        echo json_encode(['children' => $childrenData, 'images' => $imagesData]);

    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No children specified']);
}
?>
