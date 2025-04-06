<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '1234';
    private $dbName = 'members';
    private $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
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

    $stmt = $dbConnection->prepare("SELECT first_name, last_name, contact_number, birthday, program, year_section, position, profile_picture FROM members WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $profile = $stmt->get_result()->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
            $profilePicturePath = 'uploads/' . $_FILES['profile_picture']['name'];
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePicturePath);

            $updateProfilePic = $dbConnection->prepare("UPDATE members SET profile_picture = ? WHERE username = ?");
            $updateProfilePic->bind_param("ss", $profilePicturePath, $username);
            $updateProfilePic->execute();

            header("Location: profile.php");
            exit();
        }

        $firstName = $_POST['first_name'] ?? $profile['first_name'];
        $lastName = $_POST['last_name'] ?? $profile['last_name'];
        $contactNumber = $_POST['contact_number'] ?? $profile['contact_number'];
        $birthday = $_POST['birthday'] ?? $profile['birthday'];
        $program = $_POST['program'] ?? $profile['program'];
        $yearSection = $_POST['year_section'] ?? $profile['year_section'];
        $position = $_POST['position'] ?? $profile['position'];

        $updateProfile = $dbConnection->prepare("UPDATE members SET first_name = ?, last_name = ?, contact_number = ?, birthday = ?, program = ?, year_section = ?, position = ? WHERE username = ?");
        $updateProfile->bind_param("ssssssss", $firstName, $lastName, $contactNumber, $birthday, $program, $yearSection, $position, $username);
        $updateProfile->execute();

        header("Location: profile.php");
        exit();
    }
} catch (Exception $e) {
    die($e->getMessage());
}

$back_link = ($profile['position'] === 'Editor-in-Chief') ? 'dashboard.php' : 'member_dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Loader Overlay -->
<div id="loader-overlay">
    <div class="spinner"></div>
</div>
<style>
#loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.8);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
}

.spinner {
    border: 6px solid #f3f3f3;
    border-top: 6px solid #1a1851;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<script>
document.querySelector('form[action="profile.php"]').addEventListener('submit', function () {
    document.getElementById('loader-overlay').style.display = 'flex';
});
</script>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <img src="<?php echo htmlspecialchars($profile['profile_picture'] ?? 'default-profile.png'); ?>" alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <input type="file" name="profile_picture" id="profile_picture" class="d-none" onchange="this.form.submit();">
                        <br>
                        <button type="button" onclick="document.getElementById('profile_picture').click();" class="btn btn-outline-primary btn-sm">Change Picture</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form action="profile.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number" value="<?php echo htmlspecialchars($profile['contact_number'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Birthday</label>
                                <input type="date" class="form-control" name="birthday" value="<?php echo htmlspecialchars($profile['birthday'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Program</label>
                            <input type="text" class="form-control" name="program" value="<?php echo htmlspecialchars($profile['program'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year & Section</label>
                            <input type="text" class="form-control" name="year_section" value="<?php echo htmlspecialchars($profile['year_section'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="position" value="<?php echo htmlspecialchars($profile['position'] ?? ''); ?>">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo $back_link; ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
