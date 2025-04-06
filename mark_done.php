<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "1234";
    private $database = "members";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

class Task {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function markTaskAsDone($task_id) {
        $sql = "UPDATE tasks SET status = 'Done' WHERE task_id = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $task_id);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }
}

class SessionManager {
    public static function checkSession() {
        session_start();
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }
}

// Main execution
SessionManager::checkSession();

$database = new Database();
$conn = $database->getConnection();

$taskManager = new Task($conn);

if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    if ($taskManager->markTaskAsDone($task_id)) {
        header("Location: task.php?done=true");
    } else {
        echo "Error updating task status.";
    }
}

$database->closeConnection();
?>
