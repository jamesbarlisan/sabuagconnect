<?php
include "db_conn.php";

if (isset($_GET['id'])) {
    $folder_id = intval($_GET['id']);

    // Get folder name
    $folder = $conn->query("SELECT name FROM folders WHERE id = $folder_id")->fetch_assoc();
    if (!$folder) {
        echo "Folder not found.";
        exit;
    }

    $zip = new ZipArchive();
    $zip_filename = tempnam(sys_get_temp_dir(), 'zip');
    $zip->open($zip_filename, ZipArchive::CREATE);

    $media = $conn->query("SELECT file_path FROM media_repository WHERE folder_id = $folder_id");
    while ($row = $media->fetch_assoc()) {
        $file = $row['file_path'];
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        }
    }

    $zip->close();

    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=\"{$folder['name']}.zip\"");
    header("Content-Length: " . filesize($zip_filename));
    readfile($zip_filename);
    unlink($zip_filename);
    exit;
}
?>
