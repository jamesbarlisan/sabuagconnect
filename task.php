<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the task management database
$conn_task = new mysqli("localhost", "root", "1234", "members");

// Connect to the members database
$conn_members = new mysqli("localhost", "root", "1234", "members");

// Check both connections
if ($conn_task->connect_error) {
    die("Task Management DB Connection failed: " . $conn_task->connect_error);
}

if ($conn_members->connect_error) {
    die("Members DB Connection failed: " . $conn_members->connect_error);
}

// Fetch pending tasks
$sql = "SELECT * FROM tasks WHERE status = 'Pending'";
$result = $conn_task->query($sql);
$pendingTasks = $result->num_rows;

// Fetch members for the "Assign To" dropdown
$members_sql = "SELECT id, first_name, last_name FROM members WHERE position = 'writer'";
$members_result = $conn_members->query($members_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management Dashboard - SABUAG</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/task.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="dashboard-container">
        <!-- Sidebar Section -->
        <aside class="sidebar">
            <div class="logo">
                <img src="images/Logos.png" alt="SABUAG Logo">
                <h2>ADMIN</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="task.php" class="active"><i class="fas fa-tasks"></i> Tasks</a></li>
                    <li><a href="members.php"><i class="fas fa-users"></i> Members</a></li>
                    <li><a href="create_member.php"><i class="fas fa-user-plus"></i>Add New Member</a></li>
                    <li><a href="add_announcement.php"><i class="fas fa-bullhorn"></i> <span>Create Announcement</span></a></li>
                    <li><a href="media.php"><i class="fas fa-video"></i> <span>Media Repository</span></a></li>
                    <li><a href="help-center.html"><i class="fas fa-question-circle"></i> Help Center</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header>
                <h1>Task Management Dashboard</h1>
            </header>

            <div class="dashboard-summary">
                <div class="card">
                    <h3>Pending Tasks</h3>
                    <p><?php echo $pendingTasks; ?></p>
                </div>
            </div>

            <section class="task-creation">
    <h2>Create a New Task</h2>
    <form action="create_task.php" method="POST">
        <label for="task_name">Task Description:</label>
        <input type="text" id="task_name" name="task_name" required>

        <label for="assigned_to">Assign To:</label>
        <select id="assigned_to" name="assigned_to" required>
            <option value="" disabled selected>Select a member</option>
        <!-- Popup Message Box -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <p>Task assigned successfully!</p>
        <button onclick="closePopup()">Done</button>
    </div>
</div>
            <?php
            if ($members_result->num_rows > 0) {
                while ($member = $members_result->fetch_assoc()) {
                    echo "<option value='" . $member['id'] . "'>" . htmlspecialchars($member['first_name'] . " " . $member['last_name']) . "</option>";
                }
            } else {
                echo "<option value='' disabled>No members available</option>";
            }
            
            ?>
        </select>
            <br>
            <br>
        <label for="deadline">Deadline:</label>
        <input type="date" id="deadline" name="deadline" required>

        <button type="submit">Create Task</button>
    </form>
</section>
<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <p>Task assigned successfully!</p>
        <br>
        <br>
        <button onclick="closeModal()">Done</button>
    </div>
</div>

<script>
function showModal() {
    document.getElementById('successModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('successModal').style.display = 'none';
}
<?php
if (isset($_GET['task_assigned']) && $_GET['task_assigned'] == 'true') {
    echo "showModal();";
}
?>
</script>
<section class="task-list">
    <h2>Pending Tasks List</h2>
    <ul>
    <ul>
    <?php
    $sql = "SELECT tasks.*, members.first_name, members.last_name FROM tasks 
            JOIN members.members ON tasks.assigned_to = members.id
            WHERE tasks.status = 'Pending'";
    $result = $conn_task->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['task_name']) . 
                 " - Assigned to: " . htmlspecialchars($row['first_name']. $row['last_name']) . 
                 " - Deadline: " . htmlspecialchars($row['deadline']) .  "
                 <form action='mark_done.php' method='POST' style='display:inline-block;'>
    <input type='hidden' name='task_id' value='" . $row['task_id'] . "'>
    <button type='submit' class='done-button'>Done</button>
</form>
                 <form action='delete_task.php' method='POST' style='display:inline-block;'>
    <input type='hidden' name='task_id' value='" . $row['task_id'] . "'>
    <button type='submit' class='delete-button'>Delete</button>
</form>
                 </li>";
        }
    } else {
        echo "<li>No tasks available.</li>";
    }
    ?>
</ul>
<?php
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    echo "<p class='success-message'>Task deleted successfully!</p>";
}
?>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (event) {
            const confirmDelete = confirm("Are you sure you want to delete this task?");
            if (!confirmDelete) {
                event.preventDefault(); // Cancel the form submission
            }
        });
    });
</script>

    </main>
    </div>
   <!-- Footer -->
   <footer>
        <p>&copy; <?php echo date("Y"); ?> SABUAG. All rights reserved.</p>
    </footer> 
</body>
</html>
