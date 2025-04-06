<?php
session_start();

class ArticleManager {
    private $db;

    public function __construct($host, $username, $password, $database) {
        $this->db = new mysqli($host, $username, $password, $database);

        if ($this->db->connect_error) {
            throw new Exception("Connection failed: " . $this->db->connect_error);
        }
    }

    public function deleteArticle($articleId) {
        $sql = "DELETE FROM articles WHERE task_id = ?";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Statement preparation failed: " . $this->db->error);
        }

        $stmt->bind_param("i", $articleId);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting article: " . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    public function __destruct() {
        $this->db->close();
    }
}

// Renaming the class to avoid conflicts
class CustomSessionHandler {
    public static function checkUserLoggedIn() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }
}

try {
    CustomSessionHandler::checkUserLoggedIn();

    if (isset($_GET['task_id'])) {
        $articleId = (int)$_GET['task_id'];

        $articleManager = new ArticleManager('localhost', 'root', '1234', 'members');

        $articleManager->deleteArticle($articleId);

        echo "Article deleted successfully.";

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid article ID.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
