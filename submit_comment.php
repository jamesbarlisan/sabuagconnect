<?php
require 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = trim($_POST["user_name"]);
    $comment_text = trim($_POST["comment"]);
    $article_id = intval($_POST["article_id"]);

    if (empty($user_name) || empty($comment_text) || empty($article_id)) {
        echo "error"; // Ensure error messages are meaningful
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO comments (article_id, user_name, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $article_id, $user_name, $comment_text);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
    $conn->close();
}
?>
