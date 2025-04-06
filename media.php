<?php
session_start();
include "db_conn.php";

// Check if the user is logged in either as admin or member
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['member_logged_in'])) {
    // Redirect to login page or display access denied
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Media Repository | SABUAG</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .media-thumb { width: 100%; height: 200px; object-fit: cover; }
        .video-thumb { width: 100%; height: 200px; }
        .card-body { padding: 1rem; }
        .btn-back { margin-bottom: 20px; }
        .media-container { margin-top: 30px; }
        .media-card { border: 1px solid #ddd; border-radius: 10px; overflow: hidden; }
        .media-card img, .media-card video { width: 100%; border-bottom: 1px solid #ddd; }
        .media-card-body { padding: 10px; }
        .media-card-body small { font-size: 0.8rem; }
        .folder-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.folder-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 120px;
    padding: 15px;
    text-align: center;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    transition: box-shadow 0.3s, transform 0.2s;
    text-decoration: none;
    color: inherit;
}


.folder-icon {
    font-size: 40px;
    color: #f4b400;
    margin-bottom: 10px;
}
.folder-tile {
    position: relative;
}
.folder-tile .dropdown-menu {
    min-width: 120px;
}
.folder-tile .dropdown-item {
    font-size: 0.9rem;
}

.media-preview {
    cursor: pointer;
}

    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">SABUAG Media Repository</h2>
    <?php
$dashboardLink = '#'; // default fallback

if (isset($_SESSION['admin_logged_in'])) {
    $dashboardLink = 'dashboard.php';
} elseif (isset($_SESSION['member_logged_in'])) {
    $dashboardLink = 'member_dashboard.php';
}
?>

<a href="<?= $dashboardLink ?>" class="btn btn-secondary btn-back">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
</a>


<?php
$folder_filter = isset($_GET['folder_id']) ? intval($_GET['folder_id']) : null;
?>

    <!-- Upload Form (Multiple Files) -->
 <!-- Upload Form -->
<form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4 p-3 bg-white rounded shadow-sm">
  <div class="row g-2 align-items-center">
    <div class="col-md-4">
      <input type="file" name="media[]" class="form-control" multiple required>
    </div>

    <div class="col-md-2">
      <select name="type" class="form-select" required>
        <option value="" disabled selected>Select Type</option>
        <option value="photo">Photo</option>
        <option value="video">Video</option>
      </select>
    </div>

    <div class="col-md-3">
      <select name="folder_id" class="form-select" required>
        <option value="" disabled selected>Select Folder</option>
        <?php
        $folders = $conn->query("SELECT * FROM folders ORDER BY name ASC");
        while ($folder = $folders->fetch_assoc()) {
          echo "<option value='{$folder['id']}'>{$folder['name']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="col-md-1">
      <button type="submit" class="btn btn-primary w-100">Upload</button>
    </div>
  </div>
</form>
<div class="col-md-2">
      <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#newFolderModal">
        <i class="fas fa-folder-plus"></i> New Folder
      </button>
    </div>
    <br>
    <h5 class="mb-3">Folders</h5>
<div class="folder-grid">
    <a href="media.php" class="folder-tile">
        <i class="fas fa-folder-open folder-icon"></i>
        <div>All Files</div>
    </a>
    <?php
    $folders = $conn->query("SELECT * FROM folders ORDER BY name ASC");
    while ($folder = $folders->fetch_assoc()):
        $activeClass = ($folder_filter == $folder['id']) ? 'border-primary shadow-sm' : '';
    ?>
        <div class="position-relative folder-tile <?= $activeClass ?>">
    <!-- 3-dot menu -->
    <div class="dropdown position-absolute top-0 end-0 m-1">
        <button class="btn btn-sm text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu">
        <li><button type="button" class="dropdown-item" onclick="openRenameModal(<?= $folder['id'] ?>, '<?= htmlspecialchars(addslashes($folder['name'])) ?>')">Rename</button></li>
            <li><a class="dropdown-item" href="download_folder.php?id=<?= $folder['id'] ?>">Download</a></li>
            <li><form method="POST" action="delete_folder.php" onsubmit="return confirm('Are you sure you want to delete this folder?');">
                <input type="hidden" name="folder_id" value="<?= $folder['id'] ?>">
                <button class="dropdown-item text-danger" type="submit">Delete</button>
            </form></li>
        </ul>
    </div>

    <!-- Folder icon and name -->
    <a href="media.php?folder_id=<?= $folder['id'] ?>" class="text-decoration-none text-dark d-flex flex-column align-items-center">
        <i class="fas fa-folder folder-icon"></i>
        <div><?= htmlspecialchars($folder['name']) ?></div>
    </a>
</div>

    <?php endwhile; ?>
</div>


<!-- Modal -->
<div class="modal fade" id="newFolderModal" tabindex="-1" aria-labelledby="newFolderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="create_folder.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newFolderModalLabel">Create New Folder</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="folder_name" class="form-control" placeholder="Enter folder name" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Create</button>
      </div>
    </form>
  </div>
</div>

    <!-- Alerts -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Upload successful!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Upload failed. Please try again.</div>
    <?php endif; ?>

    <!-- Media Display -->
    <div class="media-container">
        <div class="row" id="media-list">
            <?php
            // Default query for media
            $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'uploaded_at';
            $order = isset($_GET['order']) ? $_GET['order'] : 'desc';
            $group_by = isset($_GET['groupby']) ? $_GET['groupby'] : 'name';

            $folder_filter = isset($_GET['folder_id']) ? intval($_GET['folder_id']) : null;

$sql = "SELECT * FROM media_repository";
if ($folder_filter) {
    $sql .= " WHERE folder_id = $folder_filter";
}
$sql .= " ORDER BY $sort_by $order";

$result = $conn->query($sql);


            while ($row = $result->fetch_assoc()):
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card media-card shadow-sm">
                    <div class="media-preview" data-bs-toggle="modal" data-bs-target="#mediaModal"
     data-type="<?= $row['file_type'] ?>" 
     data-src="<?= $row['file_path'] ?>" 
     data-title="<?= htmlspecialchars($row['file_name']) ?>">
    <?php if ($row['file_type'] == 'photo'): ?>
        <img src="<?= $row['file_path'] ?>" class="media-thumb card-img-top" alt="<?= $row['file_name'] ?>">
    <?php else: ?>
        <video class="video-thumb" muted>
            <source src="<?= $row['file_path'] ?>" type="video/mp4">
        </video>
    <?php endif; ?>
</div>
<!-- Media Preview Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="mediaModalLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" id="mediaModalBody">
        <!-- Media content will be inserted here -->
      </div>
    </div>
  </div>
</div>
<script>
document.querySelectorAll('.media-preview').forEach(el => {
    el.addEventListener('click', function () {
        const type = this.getAttribute('data-type');
        const src = this.getAttribute('data-src');
        const title = this.getAttribute('data-title');
        const modalBody = document.getElementById('mediaModalBody');
        const modalTitle = document.getElementById('mediaModalLabel');

        modalTitle.textContent = title;

        if (type === 'photo') {
            modalBody.innerHTML = `<img src="${src}" class="img-fluid rounded" alt="${title}">`;
        } else {
            modalBody.innerHTML = `
                <video controls autoplay class="w-100 rounded">
                    <source src="${src}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>`;
        }
    });
});
</script>

                        <div class="card-body media-card-body">
                            <p class="card-text"><?= $row['file_name'] ?></p>
                            <small class="text-muted"><?= $row['uploaded_at'] ?></small>
                            <form action="download.php" method="POST" class="mt-2">
                                <input type="hidden" name="file_path" value="<?= $row['file_path'] ?>">
                                <button type="submit" class="btn btn-success btn-sm w-100"><i class="fas fa-download"></i> Download</button>
                            </form>
                            <form action="delete_media.php" method="POST" class="mt-2">
                                <input type="hidden" name="media_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Handle sorting and grouping changes
    document.getElementById('sort').addEventListener('change', function() {
        updateMediaList();
    });

    document.getElementById('order').addEventListener('change', function() {
        updateMediaList();
    });

    document.getElementById('groupby').addEventListener('change', function() {
        updateMediaList();
    });

    function updateMediaList() {
        const sort = document.getElementById('sort').value;
        const order = document.getElementById('order').value;
        const groupBy = document.getElementById('groupby').value;

        window.location.href = `?sort=${sort}&order=${order}&groupby=${groupBy}`;
    }
</script>
<!-- Rename Folder Modal -->
<div class="modal fade" id="renameFolderModal" tabindex="-1" aria-labelledby="renameFolderLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="renameFolderForm" method="POST" action="rename_folder.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="renameFolderLabel">Rename</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="folder_id" id="renameFolderId">
        <input type="text" class="form-control" name="new_name" id="renameFolderName" placeholder="Enter new folder name" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">OK</button>
      </div>
    </form>
  </div>
</div>
<script>
function openRenameModal(folderId, folderName) {
  document.getElementById('renameFolderId').value = folderId;
  document.getElementById('renameFolderName').value = folderName;
  var renameModal = new bootstrap.Modal(document.getElementById('renameFolderModal'));
  renameModal.show();
}
</script>

</body>
</html>
