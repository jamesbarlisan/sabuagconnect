<?php

session_start();
$_SESSION['admin_logged_in'] = true;

class Dashboard {
    private $dbConnection;
    private $adminName;
    private $profilePicture;

    public function __construct($dbHost, $dbUser, $dbPassword, $dbName) {
        $this->connectToDatabase($dbHost, $dbUser, $dbPassword, $dbName);
        $this->checkSession();
        $this->adminName = $_SESSION['username'];
        $this->profilePicture = "images/Sherly Reyes.jpeg"; // Replace with dynamic retrieval
    }

    private function connectToDatabase($dbHost, $dbUser, $dbPassword, $dbName) {
        $this->dbConnection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if ($this->dbConnection->connect_error) {
            die("Connection failed: " . $this->dbConnection->connect_error);
        }
    }

    private function checkSession() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }

    public function getPendingTasksCount() {
        $sql = "SELECT COUNT(*) AS pending_count FROM tasks WHERE completed = 0";
        $result = $this->dbConnection->query($sql);
        return $result ? $result->fetch_assoc()['pending_count'] : 0;
    }

    public function getTotalArticles() {
        $sql = "SELECT COUNT(*) AS total_articles FROM articles";
        $result = $this->dbConnection->query($sql);
        return $result ? $result->fetch_assoc()['total_articles'] : 0;
    }

    public function getTotalMembers() {
        $sql = "SELECT COUNT(id) AS total_members FROM members";
        $result = $this->dbConnection->query($sql);
        return $result ? $result->fetch_assoc()['total_members'] : 0;
    }

    public function deleteArticle($taskId) {
        $sql = "DELETE FROM articles WHERE task_id = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("i", $taskId);

        if ($stmt->execute()) {
            echo "<script>alert('Article deleted successfully.'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to delete the article.'); window.location.href='dashboard.php';</script>";
        }

        $stmt->close();
    }

    public function getArticles() {
        $sql = "SELECT a.task_id, a.title, SUBSTRING(a.content, 1, 200) AS preview, a.date_submitted, 
                       m.first_name, m.last_name 
                FROM articles a
                LEFT JOIN members m ON a.member_id = m.id";
        return $this->dbConnection->query($sql);
    }

    public function getContactMessages() {
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS fullname, email, subject, message, created_at 
                FROM contact_messages ORDER BY created_at DESC LIMIT 5"; // Adjust limit as needed
        return $this->dbConnection->query($sql);
    }

    public function getAdminName() {
        return $this->adminName;
    }

    public function getProfilePicture() {
        return $this->profilePicture;
    }
}

$dashboard = new Dashboard("localhost", "root", "1234", "members");

if (isset($_GET['task_id'])) {
    $dashboard->deleteArticle($_GET['task_id']);
}

$pendingTasksCount = $dashboard->getPendingTasksCount();
$totalArticles = $dashboard->getTotalArticles();
$totalMembers = $dashboard->getTotalMembers();
$articles = $dashboard->getArticles();
$contactMessages = $dashboard->getContactMessages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SABUAG</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
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
                <img src="images/Logos.png" alt="SABUAG Logo">
                <h2>ADMIN</h2>
            </div>
            <nav class="sidebar-nav">
    <ul>
    <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        <li><a href="task.php"><i class="fas fa-tasks"></i> <span>Tasks</span></a></li>
        <li><a href="members.php"><i class="fas fa-users"></i> <span>Members</span></a></li>
        <li><a href="create_member.php"><i class="fas fa-user-plus"></i> <span>Add New Member</span></a></li>
        <li><a href="add_announcement.php"><i class="fas fa-bullhorn"></i> <span>Create Announcement</span></a></li>
        <li><a href="media.php"><i class="fas fa-video"></i> <span>Media Repository</span></a></li>
        <li><a href="help-center.html"><i class="fas fa-question-circle"></i> <span>Help Center</span></a></li>
    </ul>
</nav>
        </aside>
        <main class="main-content">
    <header class="header">
        <button class="collapse-btn" onclick="toggleSidebar()">☰</button>
        <h1>Welcome!</h1>
        <div class="admin-profile" onclick="toggleDropdown(event)">
            <img src="<?php echo $dashboard->getProfilePicture(); ?>" alt="Admin Profile" class="profile-pic">
            <span><?php echo $dashboard->getAdminName(); ?></span><br>
            <div class="dropdown" id="profileDropdown">
                <a href="profile.php" class="fas fa fa-user-circle"> My Profile</a>
                <a href="logout.php" class="fas fa-sign-out-alt"> Logout</a>
            </div>
        </div>
    </header>

    <!-- Dashboard Summary -->
    <section class="dashboard-summary">
        <div class="card">
            <i class="fas fa-newspaper"></i>
            <h3>Total Articles</h3>
            <p><?php echo $totalArticles; ?></p>
        </div>
        <div class="card">
            <i class="fas fa-tasks"></i>
            <h3>Tasks</h3>
            <p><?php echo $pendingTasksCount; ?></p>
        </div>
        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Active Members</h3>
            <p><?php echo $totalMembers; ?></p>
        </div>
    </section>

    <!-- Articles Section -->
    <div class="articles-container">
        <h2>Submitted Articles</h2>
        <div class="articles-section">
            <?php if ($articles->num_rows > 0): ?>
                <?php while ($row = $articles->fetch_assoc()): ?>
                    <div class='article-item'>
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Content:</strong> <?php echo htmlspecialchars($row['preview']); ?>...</p>
                        <p><strong>Author:</strong> <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></p>
                        <p><strong>Date Submitted:</strong> <?php echo htmlspecialchars($row['date_submitted']); ?></p>
                        <a href='view_article.php?task_id=<?php echo $row['task_id']; ?>' class='read-more-btn'>Read More</a>
                        <a href='delete_article.php?task_id=<?php echo $row['task_id']; ?>' class='delete-btn' onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No articles submitted yet.</p>
            <?php endif; ?>
        </div>
    </div>

</main>
<!-- Floating Chat Button -->
<div id="chatButton" class="floating-chat-btn">
    <i class="fas fa-comments"></i>
</div>

<!-- Chatbox -->
<div id="chatbox" class="chatbox">
    <div class="chatbox-header">
        <span>Recent Messages</span>
        <button id="closeChatbox" class="close-chatbox">X</button>
    </div>
    <div class="chatbox-body">
        <?php if ($contactMessages->num_rows > 0): ?>
            <?php while ($message = $contactMessages->fetch_assoc()): ?>
                <div class="message-item">
                    <p><strong>From:</strong> <?php echo htmlspecialchars($message['fullname']); ?> (<a href="mailto:<?php echo htmlspecialchars($message['email']); ?>"><?php echo htmlspecialchars($message['email']); ?></a>)</p>
                    <p><strong>Subject:</strong> <?php echo htmlspecialchars($message['subject']); ?></p>
                    <p><strong>Message:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                    <p><strong>Received at:</strong> <?php echo htmlspecialchars($message['created_at']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>
</div>
<style>
/* Floating Chat Button Styling */
.floating-chat-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #1a1851;
    color: white;
    border: none;
    border-radius: 50%;
    padding: 15px;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

/* Chatbox Styling */
.chatbox {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 300px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    z-index: 999;
}

.chatbox-header {
    background-color: #1a1851;
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    border-radius: 8px 8px 0 0;
}

.chatbox-body {
    padding: 10px;
    max-height: 300px;
    overflow-y: auto;
}

.message-item {
    margin-bottom: 10px;
    padding: 5px;
    background-color: #f1f1f1;
    border-radius: 5px;
    font-size: 15px;
}

.message-item a {
    color: #1a1851;
    text-decoration: none;
}

.message-item a:hover {
    text-decoration: underline;
}

.close-chatbox {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.close-chatbox:hover {
    color: #ccc;
}

</style>

<script>
// Toggle chatbox visibility when chat button is clicked
document.getElementById('chatButton').addEventListener('click', function() {
    var chatbox = document.getElementById('chatbox');
    chatbox.style.display = (chatbox.style.display === 'block') ? 'none' : 'block';
});

// Close chatbox when the close button is clicked
document.getElementById('closeChatbox').addEventListener('click', function() {
    document.getElementById('chatbox').style.display = 'none';
});

    function toggleDropdown(event) {
    // Prevent event from propagating and interfering with other listeners
    event.stopPropagation();
    const dropdown = document.getElementById("profileDropdown");
    dropdown.classList.toggle("show");
}

window.onclick = function () {
    // Close dropdowns if clicking outside
    const dropdowns = document.getElementsByClassName("dropdown");
    for (let i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.remove('show');
    }
};
</script>
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('collapsed');
    }
</script>

</body>
</html>
