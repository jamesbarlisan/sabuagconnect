<?php
session_start();

class ArticleViewer
{
    private $pdo;
    private $articleId;

    public function __construct($dsn, $username, $password, $articleId)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->articleId = $articleId;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function fetchArticle()
    {
        if (empty($this->articleId)) {
            return null;
        }

        $sql = "SELECT a.title, a.content, a.date_submitted, a.image_path, 
               m.first_name, m.last_name
        FROM articles a
        JOIN members m ON a.member_id = m.id
        WHERE a.task_id = :task_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['task_id' => $this->articleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

$dsn = 'mysql:host=localhost;dbname=members';
$username = 'root';
$password = '1234';
$articleId = isset($_GET['task_id']) ? $_GET['task_id'] : null;
$articleViewer = new ArticleViewer($dsn, $username, $password, $articleId);
$article = $articleViewer->fetchArticle();

if (!$article) {
    echo "Article not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ArticleViewer::escape($article['title']); ?> - SABUAG</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
        }
        .article-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .article-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .article-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .article-meta {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .article-content {
            text-align: justify;
        }

        .article-image img {
            width: 100%;
            height: auto;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
       /* Center the reaction widget */
.reaction-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 20px; /* Add spacing from the top */
}

.reaction-widget {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: fit-content; /* Prevent it from stretching */
}

.reactions {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 10px;
}

.reaction-btn {
    border: none;
    background: transparent;
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.2s, filter 0.2s;
    position: relative;
}

.reaction-btn:hover {
    transform: scale(1.2);
    filter: brightness(1.2);
}

.reaction-btn:active {
    transform: scale(1);
}

.reaction-count {
    display: block;
    font-size: 14px;
    color: #555;
    margin-top: 5px;
    font-weight: bold;
}


/* --- Comment Section Styling --- */
.comment-section {
    margin: 30px auto;
    padding: 20px;
    border-radius: 8px;
    width: 60%;
}

.comment-section h5 {
    text-align: left;
    margin-bottom: 10px;
    font-weight: bold;
}

#user_name,
#comment_text {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

#submit_comment {
    display: block;
    width: 100%;
    margin-top: 10px;
    padding: 10px;
    background: #1a1851; /* James' preferred color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

#submit_comment:hover {
    background: #fcb315; /* James' secondary preferred color */
}

/* --- Comments Display Styling --- */
#comments-container {
    margin-top: 15px;
    max-height: 300px;
    overflow-y: auto;
}

.comment {
    padding: 10px;
    margin-bottom: 10px;
    background: #f9f9f9;
    border-radius: 5px;
    border-left: 3px solid #1a1851;
}

.comment p {
    margin: 5px 0;
    font-size: 14px;
}

.comment strong {
    color: #1a1851;
}

    </style>
</head>
<body>
<!-- Header Section -->
<header>
    <!-- Top Bar -->
<div class="top-bar">
    <!-- Logo -->
    <div class="logo-container">
        <img src="images/L.png" alt="Logo">
        <p>The Official Campus Publication of University of Science and Technology of Southern Philippines - Panaon Campus</p>
    </div>

<!-- Search Icon -->
<div class="search-icon-container">
    <i class="fas fa-search" id="openSearchModal"></i>
</div>

<!-- Search Modal -->
<div id="searchModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="modal-body">
            <div class="text-container">
                <h2>Search <span>SABUAG</span></h2>
                <br>
                <br>
                <form method="GET" action="index.php">
                    <input type="text" name="search">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="image-container">
                <img src="images/IMG_3103.JPG" alt="Search Illustration">
            </div>
        </div>
    </div>
</div>
<!-- Dark Mode Toggle -->
<div class="dark-mode-toggle">
    <label class="switch">
        <input type="checkbox" id="darkModeSwitch">
        <span class="slider round"></span>
    </label>
</div>
<style>
    /* Toggle Switch Styling */
.dark-mode-toggle {
    margin-top: -5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 25px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 25px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #1a1851;
}

input:checked + .slider:before {
    transform: translateX(24px);
}

/* Dark Mode Styles */
body.dark-mode {
    background-color: #121212;
    color: #f0f0f0;
}

body.dark-mode header,
body.dark-mode .top-bar,
body.dark-mode nav,
body.dark-mode main,
body.dark-mode .sidebar {
    background-color: #1e1e1e;
    color: #f0f0f0;
}

</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('darkModeSwitch');
    const body = document.body;

    // Load saved mode
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        toggle.checked = true;
    }

    toggle.addEventListener('change', () => {
        if (toggle.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }
    });
});
</script>

</div>
<script>
// Get modal elements
const modal = document.getElementById("searchModal");
const openBtn = document.getElementById("openSearchModal");
const closeBtn = document.querySelector(".close-btn");

// Open Modal with Animation
openBtn.onclick = function () {
    modal.style.display = "flex";
    setTimeout(() => {
        document.querySelector(".modal-content").style.opacity = "1";
        document.querySelector(".modal-content").style.transform = "translateY(0)";
    }, 50);
};

// Close Modal with Fade-Out Effect
closeBtn.onclick = function () {
    document.querySelector(".modal-content").style.opacity = "0";
    document.querySelector(".modal-content").style.transform = "translateY(-20px)";
    setTimeout(() => {
        modal.style.display = "none";
    }, 200);
};

// Close Modal when clicking outside
window.onclick = function (event) {
    if (event.target === modal) {
        document.querySelector(".modal-content").style.opacity = "0";
        document.querySelector(".modal-content").style.transform = "translateY(-20px)";
        setTimeout(() => {
            modal.style.display = "none";
        }, 200);
    }
};
    
    </script>
</div>
    <nav>
    <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="member_login.php">Login</a></li>
            </ul>
    </nav>
</header>

<!-- Slideshow Section -->
<div class="slideshow-container">
    <div class="slides fade">
        <img src="uploads/a.jpg" alt="Organization Photo 1" class="banner-img"> 
    </div>
    <div class="slides fade">
        <img src="uploads/b.jpg" alt="Organization Photo 2" class="banner-img"> 
    </div>
    <div class="slides fade">
        <img src="uploads/c.jpg" alt="Organization Photo 3" class="banner-img"> 
    </div>
    <div class="slides fade">
        <img src="uploads/d.jpg" alt="Organization Photo 4" class="banner-img"> 
    </div>
    <div class="slides fade">
        <img src="uploads/e.jpg" alt="Organization Photo 5" class="banner-img"> 
    </div>

    <!-- Dots -->
    <div class="dot-container">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
    </div>
</div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<div class="article-container">
    <div class="article-header">
        <h1><?= ArticleViewer::escape($article['title']); ?></h1>
    </div>
    <div class="article-meta">
        <p>By <?= ArticleViewer::escape($article['first_name']) . " " . ArticleViewer::escape($article['last_name']); ?> 
        | Published on <?= date('F j, Y', strtotime($article['date_submitted'])); ?></p>
    </div>

    <?php if (!empty($article['image_path'])): ?>
    <div class="article-image">
        <img src="<?= ArticleViewer::escape($article['image_path']); ?>" alt="Article Image">
    </div>
    <?php endif; ?>

    <div class="article-content mt-4">
        <?php
        $content = explode("\n\n", ArticleViewer::escape($article['content']));
        if (count($content) < 3) {
            $text = implode(" ", $content);
            $sentences = preg_split('/(?<=[.!?])\s+/', $text);
            $paragraphs = array_chunk($sentences, ceil(count($sentences) / 3));
            foreach ($paragraphs as $paragraph) {
                echo "<p style='text-indent: 30px;'>" . nl2br(implode(" ", $paragraph)) . "</p>";
            }
        } else {
            foreach ($content as $paragraph) {
                if (trim($paragraph) !== "") {
                    echo "<p style='text-indent: 30px;'>" . nl2br($paragraph) . "</p>";
                }
            }
        }
        ?>
    </div>
    <div class="text-center mt-4">
    <!-- Facebook Login Button -->
    <div class="fb-login-button" 
         data-width="" 
         data-size="large" 
         data-button-type="continue_with" 
         data-layout="default" 
         data-auto-logout-link="true" 
         data-use-continue-as="true">
    </div>

    <!-- Facebook Share Button -->
    <a 
        href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://yourwebsite.com/article.php?task_id=' . $articleId); ?>" 
        target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" 
             alt="Share on Facebook" 
             style="width: 50px; height: 50px; margin: 10px;">
    </a>
</div>

<!-- Load Facebook SDK -->
<script async defer crossorigin="anonymous" 
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v15.0&appId=YOUR_APP_ID&autoLogAppEvents=1">
</script>

    </div>
<!-- Comment Section -->
<div class="comment-section">
    <h5>Conversation</h5>
    <hr>
    <input type="text" id="user_name" placeholder="Your Name" class="form-control mb-2">
    <textarea id="comment" placeholder="Write your comment..." class="form-control"></textarea>
    <button id="submit_comment" class="btn btn-primary mt-2">Post Comment</button>
    <div id="comments-container" class="mt-3">
        <?php
        require 'db_conn.php'; // Ensure database connection is included

        // Fetch comments from the database
        $articleId = isset($_GET['task_id']) ? $_GET['task_id'] : null;
        $stmt = $conn->prepare("SELECT user_name, comment, created_at FROM comments WHERE article_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='comment p-3 mb-2 border rounded'>";
                echo "<strong>" . htmlspecialchars($row['user_name']) . "</strong> <small class='text-muted'>(" . $row['created_at'] . ")</small>";
                echo "<p>" . nl2br(htmlspecialchars($row['comment'])) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p><strong>No one seems to have shared their thoughts on this topic yet.</strong><br>Leave a comment so your voice will be heard first.</p>";
        }
        ?>
    </div>
</div>

<script>
document.getElementById("submit_comment").addEventListener("click", function () {
    let userName = document.getElementById("user_name").value.trim();
    let commentText = document.getElementById("comment").value.trim();
    let articleId = "<?= $articleId ?>"; // Get article ID from PHP

    if (userName === "" || commentText === "") {
        alert("Please enter your name and comment.");
        return;
    }

    let formData = new FormData();
    formData.append("user_name", userName);
    formData.append("comment", commentText);
    formData.append("article_id", articleId);

    fetch("submit_comment.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server Response:", data); // Debugging line
        if (data.trim() === "success") {
            location.reload(); // Refresh comments
        } else {
            alert("Error posting comment: " + data);
        }
    })
    .catch(error => console.error("Error:", error));
});

</script>

<script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("slides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 4000);
        }

        function currentSlide(n) {
            slideIndex = n - 1;
            showSlides();
        }
    </script>
    </div>
<!-- Footer -->
<footer>
    <div class="footer-container">
        <div class="footer-left">
            <img src="images/Logos.png" alt="SABUAG Logo" class="footer-logo">
        </div>
        <div class="footer-center">
            <p>SABUAG &copy; 2025<br>
                All rights reserved.</p>
        </div>
        <div class="footer-right">
            <p>Follow us:</p>
            <a href="https://web.facebook.com/profile.php?id=61552137712877" target="_blank" class="social-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="social-icon" viewBox="0 0 24 24" fill="#fff" width="24px" height="24px">
                    <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.351C0 23.4.6 24 1.325 24h11.494v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.892-4.788 4.656-4.788 1.325 0 2.462.099 2.794.143v3.24h-1.918c-1.505 0-1.797.715-1.797 1.763v2.311h3.594l-.468 3.622h-3.126V24h6.127C23.4 24 24 23.4 24 22.675V1.325C24 .6 23.4 0 22.675 0z"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="footer-bottom">
        <a href="terms_of_use.php">Terms of Use</a> | <a href="privacy.php">Privacy Policy</a>
    </div>
</footer>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
