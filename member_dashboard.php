<?php
$_SESSION['member_logged_in'] = true;

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '1234';
    private $dbName = 'members';
    private $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }
}

class User {
    private $db;
    private $username;
    private $userId;

    public function __construct($db, $username) {
        $this->db = $db;
        $this->username = $username;
        
        // Fetch user ID based on username
        $stmt = $this->db->prepare("SELECT id FROM members WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            $this->userId = $user['id'];
        } else {
            throw new Exception("User not found.");
        }
    }

    // ✅ Fetch User Profile Data
    public function getProfile() {
        $stmt = $this->db->prepare("SELECT first_name, last_name, birthday, program, year_section, position FROM members WHERE id = ?");
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Fetch Assigned Tasks
    public function getTasks() {
        $stmt = $this->db->prepare("SELECT task_id, task_name, deadline, status FROM tasks WHERE assigned_to = ?");
    
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ✅ Fetch Articles by User
    public function getArticles() {
        $stmt = $this->db->prepare("SELECT task_id, title, content, date_submitted FROM articles WHERE member_id = ?");
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        return $stmt->get_result();
    }
}




session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

try {
    $database = new Database();
    $dbConnection = $database->connect();
    $user = new User($dbConnection, $username);
} catch (Exception $e) {
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="css/member_dashboard.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Loader -->
<div class="loader-wrapper">
    <img src="images/Logos.png" alt="Loader Logo" class="loader-logo">
    <script>
    $(document).ready(function(){
        setTimeout(function(){
            $(".loader-wrapper").fadeOut(500, function(){
                $(".content").fadeIn(500);
            });
        }, 2000); // Adjust delay as needed (3 seconds)
    });
</script>
    <style>
        /* Loader Styling */
        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .loader-logo {
            width: 150px;
            opacity: 0;
            animation: fadeInOut 2s infinite;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Hide content while loader is active */
        .content {
            display: none;
        }
    </style>
</div>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="images/Logos.png" alt="Member Logo">
                <h2>WRITER</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="member_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="help-center.html"><i class="fas fa-question-circle"></i> Help Center</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>
        <div class="main-content">
        <header class="header-container">
        <button class="collapse-btn" onclick="toggleSidebar()">☰</button>
    <h1>Welcome, <?php echo htmlspecialchars($user->getProfile()['first_name']?? 'User not found.'); ?>!</h1>
    <div class="profile-icon">
        <img src="images/icon.png" alt="Profile Icon" id="profileIcon" class="profile-icon-img">
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="profile.php" class="dropdown-item">Profile</a>
        </div>
    </div>
</header>
<!-- TASKS SECTION -->
<section class="section-container">
    <div class="section-header">
        <h2>Your Tasks</h2>
    </div>
    <div class="task-grid">
        <?php
        $tasks = $user->getTasks();
        if ($tasks->num_rows > 0) {
            while ($task = $tasks->fetch_assoc()) {
                echo '
                <div class="task-card">
                    <div class="task-flag ' . ($task['status'] === 'Error' ? 'error' : ($task['status'] === 'On going' ? 'ongoing' : 'default')) . '"></div>
                    <div class="task-content">
                        <h3>' . htmlspecialchars($task['task_name']) . '</h3>
                        <p class="assigned-to">Assigned to: ' . htmlspecialchars($username) . '</p>
                        <div class="task-buttons">
                            <a href="submit_article.php?task_id=' . htmlspecialchars($task['task_id']) . '" class="btn view-btn">View</a>
                            <span class="btn status-btn ' . strtolower(str_replace(' ', '-', $task['status'] ?? 'Start')) . '">' . ($task['status'] ?? 'Start') . '</span>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No tasks assigned yet.</p>';
        }
        ?>
    </div>
</section>

<!-- ARTICLES SECTION -->
<section class="section-container">
    <div class="section-header">
        <h2>Your Articles</h2>
    </div>
    <div class="articles-wrapper">
        <?php
        $articles = $user->getArticles();
        if ($articles->num_rows > 0) {
            while ($article = $articles->fetch_assoc()) {
                echo '
                <div class="article-card">
                    <h3 class="article-title">' . htmlspecialchars($article['title']) . '</h3>
                    <p class="article-date">Submitted on: ' . htmlspecialchars(date("F d, Y", strtotime($article['date_submitted']))) . '</p>
                    <p class="article-preview">' . nl2br(htmlspecialchars(mb_strimwidth($article['content'], 0, 150, '...'))) . '</p>
                    <div class="article-actions">
                        <a href="update_article.php?task_id=' . htmlspecialchars($article['task_id']) . '" class="btn edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="delete_article.php?task_id=' . htmlspecialchars($article['task_id']) . '" class="btn delete-btn" onclick="return confirm(\'Delete this article?\');"><i class="fas fa-trash"></i> Delete</a>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No articles submitted yet.</p>';
        }
        ?>
    </div>
</section>


            <script>
    document.getElementById('profileIcon').addEventListener('click', function(event) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Close the dropdown if the user clicks outside
    window.onclick = function(event) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        if (!event.target.matches('#profileIcon')) {
            dropdownMenu.style.display = 'none';
        }
    };
</script>
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('collapsed');
    }
</script>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('collapsed');
    }
</script>
        </div>
    </div>
</body>
</html>
