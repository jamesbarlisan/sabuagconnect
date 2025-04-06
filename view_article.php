<?php
class SessionManager
{
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['username']);
    }

    public static function redirectToLogin()
    {
        header("Location: login.php");
        exit();
    }
}

class Database
{
    private $connection;

    public function __construct($host, $username, $password, $database)
    {
        $this->connection = new mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

class Article
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getArticleById(int $id): ?array
    {
        $sql = "
            SELECT 
                a.title, 
                a.content, 
                a.date_submitted, 
                m.first_name, 
                m.last_name
            FROM articles a
            JOIN members m ON a.member_id = m.id
            WHERE a.task_id = ?";
            
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}

SessionManager::startSession();
if (!SessionManager::isLoggedIn()) {
    SessionManager::redirectToLogin();
}

try {
    $db = new Database("localhost", "root", "1234", "members");
    $articleHandler = new Article($db);

    if (isset($_GET['task_id'])) {
        $id = intval($_GET['task_id']);
        $article = $articleHandler->getArticleById($id);

        if (!$article) {
            echo "<p>Article not found.</p>";
            exit();
        }
    } else {
        echo "<p>No article ID provided.</p>";
        exit();
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Article - SABUAG</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/view.css">
</head>
<body>
    <div class="main-content">
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($article['first_name'] . " " . $article['last_name']); ?></p>
        <p><strong>Date Submitted:</strong> <?php echo htmlspecialchars($article['date_submitted']); ?></p>
        <hr>
        <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
        <a href="dashboard.php" class="read-more-btn">Back to Dashboard</a>
    </div>
</body>
</html>
