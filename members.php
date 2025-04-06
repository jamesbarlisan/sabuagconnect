<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '1234';
    private $dbname = 'members';
    private $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

class Member {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTotalMembers() {
        $sql = "SELECT COUNT(id) AS total_members FROM members";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total_members'];
        }

        return 0;
    }

    public function getMembers() {
        $sql = "SELECT id, first_name, last_name, birthday, program, year_section, position FROM members";
        return $this->conn->query($sql);
    }

    public function deleteMember($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM members WHERE id='$id'";
        return $this->conn->query($sql);
    }
}

$database = new Database();
$conn = $database->connect();
$member = new Member($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $memberId = $_POST['member_id'];
    if ($member->deleteMember($memberId)) {
        $message = "Member deleted successfully.";
    } else {
        $message = "Error deleting member.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members - SABUAG Dashboard</title>
    <link rel="stylesheet" href="css/members.css">
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
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
                <li><a href="members.php" class="active"><i class="fas fa-users"></i> Members</a></li>
                <li><a href="create_member.php"><i class="fas fa-user-plus"></i>Add New Member</a></li>
                <li><a href="add_announcement.php"><i class="fas fa-bullhorn"></i> <span>Create Announcement</span></a></li>
                <li><a href="media.php"><i class="fas fa-video"></i> <span>Media Repository</span></a></li>
                <li><a href="help-center.html"><i class="fas fa-question-circle"></i> Help Center</a></li>
            </ul>
        </nav>
    </aside>
    <div class="main-content">
        <h1>Members List</h1>
        <br>
        <div class="dashboard-summary">
            <div class="summary-item">
                <h2>Active Members</h2>
                <p>Total Active Members: <strong><?php echo $member->getTotalMembers(); ?></strong></p>
            </div>
        </div>
        <div class="members-list">
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }

            $result = $member->getMembers();
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='member-card'>";
                    echo "<h3>" . $row['first_name'] . " " . $row['last_name'] . "</h3>";
                    echo "<p><strong>Birthday:</strong> {$row['birthday']}</p>";
                    echo "<p><strong>Program:</strong> {$row['program']}</p>";
                    echo "<p><strong>Year and Section:</strong> {$row['year_section']}</p>";
                    echo "<p><strong>Position:</strong> {$row['position']}</p>";

                    echo "<form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this member?\");'>";
                    echo "<input type='hidden' name='member_id' value='{$row['id']}'>";
                    echo "<button type='submit' name='delete' class='delete-btn'><i class='fas fa-trash'></i> Delete</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                echo "<p>No members registered yet.</p>";
            }
            ?>
        </div>
    </div>
</div>
<footer>
    <p>&copy; <?php echo date("Y"); ?> SABUAG. All rights reserved.</p>
</footer>
<?php $database->close(); ?>
</body>
</html>
