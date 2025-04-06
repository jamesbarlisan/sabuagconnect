<?php
session_start();
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['folder_id'], $_POST['new_name'])) {
    $folder_id = intval($_POST['folder_id']);
    $new_name = trim($_POST['new_name']);

    if ($new_name !== '') {
        $stmt = $conn->prepare("UPDATE folders SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $new_name, $folder_id);
        if ($stmt->execute()) {
            header("Location: media.php?success=folder_renamed");
        } else {
            header("Location: media.php?error=rename_failed");
        }
        $stmt->close();
    } else {
        header("Location: media.php?error=empty_name");
    }
} else {
    header("Location: media.php?error=invalid_request");
}
?>
