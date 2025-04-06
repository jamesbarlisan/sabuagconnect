<?php
include 'db_conn.php';

$folder_name = trim($_POST['folder_name']);
if ($folder_name) {
    $stmt = $conn->prepare("INSERT INTO folders (name) VALUES (?)");
    $stmt->bind_param("s", $folder_name);
    $stmt->execute();
}

header("Location: media.php");
exit;
