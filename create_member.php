<?php
session_start();
require_once 'db_conn.php';

class Auth {
    public static function checkLogin() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }
}

class MemberManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createMember($data) {
        $message = "";
        try {
            $this->pdo->beginTransaction();

            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt_users = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt_users->execute([
                ':username' => $data['username'],
                ':password' => $hashedPassword
            ]);

            $stmt_members = $this->pdo->prepare(
                "INSERT INTO members (username, first_name, last_name, birthday, program, year_section, position) 
                 VALUES (:username, :first_name, :last_name, :birthday, :program, :year_section, :position)"
            );
            $stmt_members->execute([
                ':username' => $data['username'],
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':birthday' => $data['birthday'],
                ':program' => $data['program'],
                ':year_section' => $data['year_section'],
                ':position' => $data['position']
            ]);

            $this->pdo->commit();
            $message = "Member account created successfully.";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            $message = "Error creating member account: " . $e->getMessage();
        }

        return $message;
    }
}

Auth::checkLogin();

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $memberManager = new MemberManager($pdo);
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'username' => trim($_POST['username']),
        'password' => trim($_POST['password']),
        'first_name' => trim($_POST['firstname']),
        'last_name' => trim($_POST['lastname']),
        'birthday' => trim($_POST['birthday']),
        'program' => trim($_POST['program']),
        'year_section' => trim($_POST['year_section']),
        'position' => trim($_POST['position']),
    ];

    if (array_filter($data, 'strlen')) {
        $message = $memberManager->createMember($data);
    } else {
        $message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/png" href="images/Logos.png">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #1a1851;
        }

        form {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            font-size: 0.9rem;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        form button {
            display: block;
            width: 100%;
            background: #fcb315;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s background ease;
        }

        form button:hover {
            background: #e0a30c;
        }
        .alert-message {
            text-align: center;
            font-size: 1rem;
            margin-bottom: 15px;
            color: red;
        }

        @media (max-width: 600px) {
            .sidebar {
                flex: 0 0 100%;
                min-height: auto;
                text-align: center;
            }

            .main-content {
                padding: 10px;
            }

            form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="images/Logos.png" alt="SABUAG Logo">
                <h2>ADMIN</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="task.php"><i class="fas fa-tasks"></i> Tasks</a></li>
                    <li><a href="members.php"><i class="fas fa-users"></i> Members</a></li>
                    <li><a href="create_member.php" class="active"><i class="fas fa-user-plus"></i>Add New Member</a></li>
                    <li><a href="add_announcement.php"><i class="fas fa-bullhorn"></i> <span>Create Announcement</span></a></li>
                    <li><a href="media.php"><i class="fas fa-video"></i> <span>Media Repository</span></a></li>
                    <li><a href="help-center.html"><i class="fas fa-question-circle"></i> Help Center</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>Add New Member</h1>
            </header>

            <section>
                <?php if ($message): ?>
                    <p><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>
                <form method="POST" action="create_member.php">
                    
                    <label for="fullname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required>

                    <label for="fullname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required>

                    <label for="birthday">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" required>

                    <label for="program">Program:</label>
                <select id="program" name="program" required>
                    <option value="" disabled selected>Select your program</option>
                    <option value="BS Information Technology">BS Information Technology</option>
                    <option value="BS Marine Biology">BS Marine Biology</option>
                    <option value="BTLE Industrial Arts">BTLE Industrial Arts</option>
                    <option value="BTLE Home Economics">BTLE Home Economics</option>
                </select>

                    <label for="year_section">Year & Section:</label>
                    <input type="text" id="year_section" name="year_section" required>

                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Create Account</button>
                </form>
            </section>
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
    </div>
</body>
</html>
