<?php
include 'db_conn.php';

// Check if media_id is passed
if (isset($_POST['media_id'])) {
    $media_id = $_POST['media_id'];

    // Prepare the SQL query to delete the media
    $sql = "SELECT * FROM media_repository WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $media_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if media exists
    if ($result->num_rows > 0) {
        // Fetch the media record
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];

        // Delete the media file from the server
        if (file_exists($file_path)) {  
            unlink($file_path);
        }

        // Delete the media record from the database
        $sql_delete = "DELETE FROM media_repository WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $media_id);
        $stmt_delete->execute();

        // Redirect with success message
        header("Location: media.php?success=1");
    } else {
        // Redirect with error message if media not found
        header("Location: media.php?error=1");
    }
} else {
    // Redirect with error message if media_id is not set
    header("Location: media.php?error=1");
}

exit;
?>
