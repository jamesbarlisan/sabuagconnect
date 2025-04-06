<?php
session_start();

class TaskManager
{
    private $db;

    public function __construct()
    {
        $this->connectDatabase();
        $this->checkUserAuthentication();
    }

    private function connectDatabase()
    {
        $this->db = new mysqli('localhost', 'root', '1234', 'members');
        if ($this->db->connect_error) {
            die("Database connection failed: " . $this->db->connect_error);
        }
    }

    private function checkUserAuthentication()
    {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }

    public function deleteTask($taskId)
    {
        $sql = "DELETE FROM tasks WHERE task_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $taskId);
            if ($stmt->execute()) {
                header("Location: member_dashboard.php?message=Task deleted successfully");
                exit();
            } else {
                echo "Error deleting task: " . $this->db->error;
            }
        } else {
            echo "Error preparing statement: " . $this->db->error;
        }
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
            $taskId = intval($_POST['task_id']);
            $this->deleteTask($taskId);
        } else {
            echo "Invalid request.";
        }
    }

    public function __destruct()
    {
        $this->db->close();
    }
}

$taskManager = new TaskManager();
$taskManager->handleRequest();
?>
