<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "1234";
    private $database = "members";
    private $conn;

    public function connect()
    {
        if ($this->conn === null) {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }

    public function close()
    {
        if ($this->conn !== null) {
            $this->conn->close();
        }
    }
}

class TaskManager
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function deleteTask($taskId)
    {
        $conn = $this->db->connect();
        $sql = "DELETE FROM tasks WHERE task_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("i", $taskId);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
    }
}

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['task_id'])) {
        $taskId = $_POST['task_id'];

        $database = new Database();
        $taskManager = new TaskManager($database);

        if ($taskManager->deleteTask($taskId)) {
            header("Location: task.php?delete_success=true");
            exit();
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($database)) {
        $database->close();
    }
}

?>
