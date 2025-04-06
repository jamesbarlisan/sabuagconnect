<?php
// Autoloader for class files
spl_autoload_register(function ($class) {
    include_once $class . '.php';
});

// Database Connection Class
class Database
{
    private $host = 'localhost';
    private $db = 'members';
    private $user = 'root';
    private $pass = '1234';
    private $pdo;

    public function connect()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}

// User Class
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: member_dashboard.php");
            exit;
        }

        return "Invalid username or password.";
    }
}

// Login Controller
class LoginController
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            return $this->user->login($username, $password);
        }

        return null;
    }
}

// Start a session
session_start();

// Initialize the application
try {
    $database = new Database();
    $pdo = $database->connect();

    $user = new User($pdo);
    $loginController = new LoginController($user);

    $errorMessage = $loginController->handleRequest();

    if ($errorMessage) {
        echo $errorMessage;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
