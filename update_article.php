<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "1234", "members");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_SESSION['username'];

if (!isset($_GET['task_id'])) {
    die("Missing article ID.");
}

$task_id = intval($_GET['task_id']);

$query = "SELECT * FROM articles WHERE task_id = ? AND member_id = (SELECT id FROM members WHERE username = ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("is", $task_id, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Article not found or unauthorized access.");
}

$article = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_title = $_POST['title'] ?? '';
    $new_content = $_POST['content'] ?? '';

    $image_path = $article['image'] ?? null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    $update_query = "UPDATE articles SET title = ?, content = ?, image_path = ?, date_submitted = NOW() WHERE task_id = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param("sssi", $new_title, $new_content, $image_path, $task_id);
    $update_stmt->execute();

    header("Location: member_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="row g-0">
                        <div class="col-md-6 bg-secondary-subtle p-4 d-flex flex-column justify-content-center">
                            <?php if (!empty($article['image'])): ?>
                                <div class="text-center">
                                    <label class="form-label fw-semibold">Current Image</label>
                                    <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image" class="img-fluid rounded shadow-sm">
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted">No image available</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 p-5">
                            <h3 class="mb-4 text-center">Edit Article</h3>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                                    <label for="title">Title</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="content" name="content" style="height: 200px" required><?php echo htmlspecialchars($article['content']); ?></textarea>
                                    <label for="content">Content</label>
                                </div>

                                <div class="mb-4">
                                    <label for="image" class="form-label">Change Image (optional)</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Update Article</button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <a href="member_dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>