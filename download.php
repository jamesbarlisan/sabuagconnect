<?php
if (isset($_POST['file_path'])) {
    $filePath = $_POST['file_path'];

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to trigger file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        // Handle file not found error
        echo "Error: File not found.";
    }
} else {
    echo "Error: No file specified for download.";
}
?>
