<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media']) && isset($_POST['folder_id']) && isset($_POST['type'])) {
    $mediaFiles = $_FILES['media'];
    $type = $_POST['type']; // 'photo' or 'video'
    $folder_id = intval($_POST['folder_id']);

    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $allowedPhotos = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedVideos = ['mp4', 'webm', 'ogg'];

    for ($i = 0; $i < count($mediaFiles['name']); $i++) {
        $fileName = basename($mediaFiles['name'][$i]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Unique file name to avoid collisions
        $uniqueName = time() . "_" . $fileName;
        $targetFilePath = $targetDir . $uniqueName;

        if (($type === 'photo' && in_array($fileType, $allowedPhotos)) ||
            ($type === 'video' && in_array($fileType, $allowedVideos))) {

            if (move_uploaded_file($mediaFiles['tmp_name'][$i], $targetFilePath)) {
                $stmt = $conn->prepare("INSERT INTO media_repository (file_name, file_type, file_path, folder_id, uploaded_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("sssi", $fileName, $type, $targetFilePath, $folder_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    header("Location: media.php?success=1");
    exit();
} else {
    header("Location: media.php?error=1");
    exit();
}
?>
