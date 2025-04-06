<?php

session_start();

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '1234';
    private $dbname = 'members';
    private $conn;

    public function connect() {
        if ($this->conn === null) {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

            if ($this->conn->connect_error) {
                die("Database connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }
}

class FileUploader {
    private $targetDir;
    private $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    private $maxSize = 5000000; // 5MB

    public function __construct($targetDir = "uploads/") {
        $this->targetDir = $targetDir;
    }

    public function upload($file) {
        $targetFile = $this->targetDir . basename($file["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file
        if (!getimagesize($file["tmp_name"])) {
            throw new Exception("File is not an image.");
        }
        if ($file["size"] > $this->maxSize) {
            throw new Exception("File is too large.");
        }
        if (!in_array($fileType, $this->allowedTypes)) {
            throw new Exception("Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        // Move the uploaded file
        if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
            throw new Exception("Error uploading the file.");
        }

        return $targetFile;
    }
}

class ArticleSubmission {
    private $db;
    private $task_id;
    private $username;

    public function __construct(Database $db, $task_id, $username) {
        $this->db = $db;
        $this->task_id = $task_id;
        $this->username = $username;
    }

    public function submit($title, $content, $imagePath) {
        $conn = $this->db->connect();
        $dateSubmitted = date('Y-m-d');
        $memberId = $this->username;

        $memberId = null;

$stmt = $conn->prepare("SELECT id FROM members WHERE username = ?");
$stmt->bind_param("s", $this->username);
$stmt->execute();
$stmt->bind_result($memberId);
if (!$stmt->fetch()) {
    throw new Exception("Member ID not found for the given username.");
}
$stmt->close();


        // Insert article
        $stmt = $conn->prepare("INSERT INTO articles (title, content, member_id, date_submitted, task_id, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $content, $memberId, $dateSubmitted, $this->task_id, $imagePath);

        if (!$stmt->execute()) {
            throw new Exception("Error saving article: " . $stmt->error);
        }

        // Mark task as completed
        $updateStmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE task_id = ?");
        $updateStmt->bind_param("i", $this->task_id);
        if (!$updateStmt->execute()) {
            throw new Exception("Error updating task status: " . $updateStmt->error);
        }

        $stmt->close();
        $updateStmt->close();
    }
}

$task_id = $_GET['task_id'];
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    try {
        $db = new Database();
        $uploader = new FileUploader();
        $imagePath = $uploader->upload($_FILES["image"]);

        $articleSubmission = new ArticleSubmission($db, $task_id, $username);
        $articleSubmission->submit($title, $content, $imagePath);

        header("Location: member_dashboard.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Article</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-header {
            background-color: #1a1851;
            color: #fff;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }
        .card-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .btn {
            border-radius: 5px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            width: 100%;
        }
        .btn-success {
            background-color: #fcb315;
            border: none;
            color: #fff;
        }
        .btn-success:hover {
            background-color: #e0a400;
        }
        .btn-secondary {
            background-color: #ddd;
            border: none;
            color: #333;
        }
        .btn-secondary:hover {
            background-color: #bbb;
        }
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-pen"></i> Write your Article</h2>
            </div>
            <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title"><i class="fas fa-heading"></i> Title/Headline:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="form-group">
        <label for="content"><i class="fas fa-align-left"></i> Content:</label>
        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
    </div>

    <div class="form-group">
        <label for="image"><i class="fas fa-image"></i> Upload Image:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
    </div>

    <div class="form-group">
        <label for="author"><i class="fas fa-user"></i> Author:</label>
        <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($username); ?>" disabled>
    </div>

    <div class="form-group">
        <label for="date_submitted"><i class="fas fa-calendar-day"></i> Date Submitted:</label>
        <input type="text" class="form-control" id="date_submitted" name="date_submitted" value="<?= date('Y-m-d'); ?>" disabled>
    </div>

    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit Article</button>
</form>

                <br>    
                <a href="member_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Go Back</a>
            </div>
        </div>
    </div>
</body>
</html>
