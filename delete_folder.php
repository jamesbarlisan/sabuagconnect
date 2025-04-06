<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['folder_id'])) {
    $folder_id = intval($_POST['folder_id']);

    // Optional: delete associated media first
    $conn->query("DELETE FROM media_repository WHERE folder_id = $folder_id");

    // Then delete folder
    $stmt = $conn->prepare("DELETE FROM folders WHERE id = ?");
    $stmt->bind_param("i", $folder_id);
    $stmt->execute();

    header("Location: media.php");
    exit;
}
?>
