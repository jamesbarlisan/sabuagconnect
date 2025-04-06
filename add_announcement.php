<?php
session_start();

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
            die("Database connection failed: " . $this->dbConnection->connect_error);
        }
    }

    private function checkSession() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
    }

    public function createAnnouncement($title, $content) {
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));

        $sql = "INSERT INTO announcements (title, content, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('Announcement created successfully.'); window.location.href='add_announcement.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to create announcement.');</script>";
        }

        $stmt->close();
    }

    public function fetchAnnouncements() {
        $sql = "SELECT * FROM announcements ORDER BY created_at DESC";
        return $this->dbConnection->query($sql);
    }

    public function deleteAnnouncement($id) {
        $sql = "DELETE FROM announcements WHERE id = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updateAnnouncement($id, $title, $content) {
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));

        $sql = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Announcement updated successfully!'); window.location.href='add_announcement.php';</script>";
        } else {
            echo "<script>alert('Error updating announcement!');</script>";
        }
        $stmt->close();
    }

    public function __destruct() {
        $this->dbConnection->close();
    }
}

$dashboard = new Dashboard("localhost", "root", "1234", "members");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['content']) && !isset($_POST['id'])) {
        $dashboard->createAnnouncement($_POST['title'], $_POST['content']);
    } elseif (isset($_POST['delete'])) {
        if ($dashboard->deleteAnnouncement($_POST['delete'])) {
            echo "<script>alert('Announcement deleted successfully.'); window.location.href='add_announcement.php';</script>";
        } else {
            echo "<script>alert('Failed to delete announcement.');</script>";
        }
    } elseif (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
        $dashboard->updateAnnouncement($_POST['id'], $_POST['title'], $_POST['content']);
    }
}

$announcements = $dashboard->fetchAnnouncements();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement - Admin</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="task.php"><i class="fas fa-tasks"></i> <span>Tasks</span></a></li>
                <li><a href="members.php"><i class="fas fa-users"></i> <span>Members</span></a></li>
                <li><a href="create_member.php"><i class="fas fa-user-plus"></i> <span>Add New Member</span></a></li>
                <li><a href="add_announcement.php" class="active"><i class="fas fa-bullhorn"></i> <span>Create Announcement</span></a></li>
                <li><a href="media.php"><i class="fas fa-video"></i> <span>Media Repository</span></a></li>
                <li><a href="help-center.html"><i class="fas fa-question-circle"></i> <span>Help Center</span></a></li>
            </ul>
        </nav>
    </aside>
    <main class="main-content">
        <header class="header">
            <h1>Create New Announcement</h1>
        </header>

        <section class="create-announcement-form">
            <h2>New Announcement</h2>
            <form action="add_announcement.php" method="POST">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter announcement title..." required>

                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="5" placeholder="Write your announcement here..." required></textarea>

                <button type="submit"><i class="fas fa-paper-plane"></i> Publish Announcement</button>
            </form>
        </section>

        <section class="announcements">
            <h2>Recent Announcements</h2>
            <ul>
                <?php if ($announcements && $announcements->num_rows > 0): ?>
                    <?php while ($row = $announcements->fetch_assoc()): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p><?php echo htmlspecialchars($row['content']); ?></p>
                            <small>Posted on: <?php echo date("F j, Y", strtotime($row['created_at'])); ?></small>

                            <button class="btn btn-sm btn-outline-primary" onclick="showEditForm(<?= $row['id'] ?>, '<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['content'], ENT_QUOTES) ?>')" data-bs-toggle="modal" data-bs-target="#updateAnnouncementModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="add_announcement.php" method="POST" style="display: inline;">
                                <input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this announcement?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No announcements available.</p>
                <?php endif; ?>
            </ul>
        </section>

        <!-- Update Modal -->
        <div class="modal fade" id="updateAnnouncementModal" tabindex="-1" aria-labelledby="updateAnnouncementModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="updateAnnouncementModalLabel"><i class="fas fa-edit"></i> Update Announcement</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="add_announcement.php">
                        <div class="modal-body">
                            <input type="hidden" id="updateId" name="id">

                            <div class="mb-3">
                                <label for="updateTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="updateTitle" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="updateContent" class="form-label">Content</label>
                                <textarea class="form-control" id="updateContent" name="content" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
function showEditForm(id, title, content) {
    document.getElementById('updateId').value = id;
    document.getElementById('updateTitle').value = title;
    document.getElementById('updateContent').value = content;
}
</script>

<style>
.modal-header {
    background-color: #1a1851;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
