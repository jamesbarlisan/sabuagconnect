<?php
session_start();

class Database {
    private $host = 'localhost';
    private $dbname = 'members';
    private $username = 'root';
    private $password = '1234';
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function disconnect() {
        $this->pdo = null;
    }
}

class Auth {
    public static function checkLogin() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }
}

class TaskManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function assignTask($taskName, $assignedTo, $deadline) {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO tasks (task_name, assigned_to, deadline) VALUES (:task_name, :assigned_to, :deadline)"
            );
            $stmt->execute([
                ':task_name' => $taskName,
                ':assigned_to' => $assignedTo,
                ':deadline' => $deadline
            ]);

            header("Location: task.php?task_assigned=true");
            exit();
        } catch (Exception $e) {
            return "Error assigning task: " . $e->getMessage();
        }
    }
}

Auth::checkLogin();

$message = "";
try {
    $db = new Database();
    $pdo = $db->getConnection();
    $taskManager = new TaskManager($pdo);
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name']);
    $assigned_to = intval($_POST['assigned_to']);
    $deadline = trim($_POST['deadline']);

    if ($task_name && $assigned_to && $deadline) {
        $message = $taskManager->assignTask($task_name, $assigned_to, $deadline);
    } else {
        $message = "All fields are required.";
    }
}
?>
