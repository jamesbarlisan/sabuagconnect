<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '1234';
    private $database = 'members';
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function close() {
        $this->connection->close();
    }
    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }
    
}

class Article {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getLatestArticles($search = '') {
        // Start SQL query
        $sql = "SELECT title, content, task_id, image_path FROM articles";
    
        // Apply search filter
        if (!empty($search)) {
            $escapedSearch = $this->db->escapeString($search); // ✅ Use new escape method
            $sql .= " WHERE title LIKE '%$escapedSearch%'";
        }
    
        // Add ORDER BY clause
        $sql .= " ORDER BY task_id DESC";
    
        // Execute query
        $result = $this->db->query($sql);
    
        // Fetch results
        $articles = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
    
        return $articles;
    }
public function escapeString($string) {
    return $this->connection->real_escape_string($string);
    $escapedSearch = $this->db->escapeString($search);

}
    public function getAnnouncements() {
        $sql = "SELECT title, content, created_at FROM announcements ORDER BY created_at DESC LIMIT 5";
        return $this->db->query($sql); // Return the raw result set directly
    }
    
    
} // <-- Added the missing closing bracket here

class Dashboard {
    private $db;

    public function __construct($host, $username, $password, $database) {
        $this->db = new Database($host, $username, $password, $database);
    }

    public function displayDashboard() {
        // Add logic to fetch and display dashboard-related data
    }
}

// ✅ Correctly place these statements OUTSIDE the class definition
$database = new Database();
$articleManager = new Article($database);

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$articles = $articleManager->getLatestArticles($searchTerm);

$announcements = $articleManager->getAnnouncements();

$database->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SABUAG - Student Campus Publication</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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

    <main>
    <div class="main-container">
        <div class="content">
            <section class="welcome">
                <h1>Welcome to SABUAG Connect</h1>
                <p>Stay updated with the latest campus news and information.</p>
            </section>
            <!-- Redesigned Top Stories Section with Full Image Cover and Overlay Title -->
<section class="top-stories">
  <div class="card-container">
    <div class="preview-section">
      <img src="IMG_3102.JPG" id="previewImage" alt="Preview Image" />
      <div class="overlay">
        <span class="category-badge">News</span>
        <h3 id="previewTitle">Hover over an article →</h3>
        <div class="meta">
          <span><i class="fa fa-user"></i>   SABUAG</span>
        </div>
      </div>
    </div>
    <div class="article-list">
      <h2 class="section-title">Recent Articles</h2>
      <ul class="story-titles">
        <?php foreach ($articles as $article): ?>
          <li class="story-title-item"
              data-title="<?php echo htmlspecialchars($article['title']); ?>"
              data-image="<?php echo htmlspecialchars($article['image_path']); ?>">
            <a href="article.php?task_id=<?php echo $article['task_id']; ?>">
              <?php echo htmlspecialchars($article['title']); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- Redesigned Styles -->
<style>
.top-stories {
  padding: 2rem;
  background: #f5f7fa;
  font-family: 'Segoe UI', sans-serif;
}

.card-container {
  display: flex;
  background: white;
  border-radius: 13px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  min-height: 400px;
}

.preview-section {
  flex: 1;
  position: relative;
  overflow: hidden;
}

.preview-section img {
  width: 150%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.preview-section .overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  padding: 1.5rem;
  width: 100%;
  background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
  color: white;
  box-sizing: border-box;
}

.overlay h3 {
  font-size: 1.25rem;
  margin: 0.5rem 0;
  font-weight: 700;
}

.category-badge {
  display: inline-block;
  background-color: #fcb315;
  padding: 0.3rem 0.6rem;
  border-radius: 999px;
  font-size: 0.75rem;
  font-weight: 600;
  margin-bottom: 0.3rem;
}

.meta {
  display: flex;
  gap: 1rem;
  font-size: 0.8rem;
  opacity: 0.9;
  align-items: center;
}

.article-list {
  flex: 1;
  padding: 1.5rem;
}

.section-title {
  margin-bottom: 1rem;
  font-size: 1.5rem;
  font-weight: bold;
  color: #0d1a3d;
  
}

.story-titles {
  list-style: none;
  padding: 0;
  margin: 0;
}

.story-title-item {
  padding: 0.75rem;
  margin-bottom: 0.5rem;
  border-radius: 8px;
  transition: background 0.3s;
  cursor: pointer;
  text-align: left;
}

.story-title-item:hover {
  background-color: #e9eef6;
}

.story-title-item a {
  text-decoration: none;
  color: #1a1a1a;
  font-weight: 600;
}
.story-title-item {
  position: relative;
  padding: 0.75rem 1rem;
  margin-bottom: 0.5rem;
  border-radius: 8px;
  transition: background 0.3s;
  cursor: pointer;
}

.story-title-item.active,
.story-title-item:hover {
  background-color: #e9eef6;
}

/* Arrow for the active item */
.story-title-item.active::before {
  content: "";
  position: absolute;
  left: -15px;
  top: 50%;
  transform: translateY(-50%);
  width: 0;
  height: 0;
  border-top: 12px solid transparent;
  border-bottom: 12px solid transparent;
  border-right: 12px solid white; /* same as item background */
}

</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const titleItems = document.querySelectorAll(".story-title-item");
  const previewImage = document.getElementById("previewImage");
  const previewTitle = document.getElementById("previewTitle");

  titleItems.forEach(item => {
    item.addEventListener("mouseenter", () => {
      // Set preview content
      previewImage.src = item.dataset.image;
      previewTitle.textContent = item.dataset.title;

      // Update active class
      titleItems.forEach(i => i.classList.remove("active"));
      item.classList.add("active");
    });
  });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const titleItems = document.querySelectorAll(".story-title-item");
  const previewImage = document.getElementById("previewImage");
  const previewTitle = document.getElementById("previewTitle");

  titleItems.forEach(item => {
    item.addEventListener("mouseenter", () => {
      previewImage.src = item.dataset.image;
      previewTitle.textContent = item.dataset.title;
    });
  });
});
</script>

                   </div>

        <!-- Sidebar for Announcements -->
        <aside class="sidebar">
    <h2>Recent Announcements</h2>
    <ul class="announcement-list">
        <?php if ($announcements && $announcements->num_rows > 0): ?>
            <?php while ($row = $announcements->fetch_assoc()): ?>
                <li class="announcement-card">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['content']); ?></p>
                    <small><i class="fa fa-calendar"></i> Posted on: <?php echo date("F j, Y", strtotime($row['created_at'])); ?></small>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No announcements available.</p>
        <?php endif; ?>
    </ul>
    

 <!-- Calendar Widget -->
<div class="calendar-widget">
    <h2>Calendar</h2>
    <iframe src="https://calendar.google.com/calendar/embed?src=en.philippines%23holiday%40group.v.calendar.google.com&ctz=Asia/Manila" style="border: 0" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
</div>

</aside>

<script>
// Real-time Calendar
function updateCalendar() {
    const calendarElement = document.getElementById("calendar");
    const today = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    calendarElement.innerHTML = `<p>${today.toLocaleDateString("en-US", options)}</p>`;
}

// Call calendar update function
updateCalendar();
</script>

    </div>
    <section class="video-gallery">
    <h2>Campus Spotlight</h2>
    <div class="video-container">
        <iframe id="youtube-frame" width="100%" height="400" src="https://www.youtube.com/embed/Ar3dlaTbsYI" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="video-controls">
        <button onclick="showPreviousVideo()">Previous</button>
        <button onclick="showNextVideo()">Next</button>
    </div>
</section>
<script>
const videoUrls = [
    "https://www.youtube.com/embed/Ar3dlaTbsYI",
    "https://www.youtube.com/embed/8pu2B_7Wx30"
];
let currentVideo = 0;

function showVideo(index) {
    const frame = document.getElementById("youtube-frame");
    frame.src = videoUrls[index];
}

function showNextVideo() {
    currentVideo = (currentVideo + 1) % videoUrls.length;
    showVideo(currentVideo);
}

function showPreviousVideo() {
    currentVideo = (currentVideo - 1 + videoUrls.length) % videoUrls.length;
    showVideo(currentVideo);
}
</script>

</main>

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
    <script>
const ctx = document.getElementById('enrollmentChart').getContext('2d');
const enrollmentChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["BS Information Technology", "BS Marine Biology", "BTLED Major in Home Economics", "BTLED Major in Industrial Arts"],
        datasets: [{
            label: 'Enrollment Statistics',
            data: [280, 817, 207, 191],
            backgroundColor: [
                '#1a1851', 
                '#fcb315', 
                '#6ec1e4', 
                '#87b37a'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let totalStudents = 1495;
                        let percentage = ((context.raw / totalStudents) * 100).toFixed(2);
                        return `${context.label}: ${context.raw} (${percentage}%)`;
                    }
                }
            }
        }
    }
});
let currentStoryIndex = 0;

function changeStory(direction) {
    const storiesWrapper = document.querySelector('.stories-wrapper');
    const stories = document.querySelectorAll('.story');
    const totalStories = stories.length;

    // Update the current index based on the direction
    currentStoryIndex += direction;

    // Loop back to the beginning or end if out of bounds
    if (currentStoryIndex < 0) {
        currentStoryIndex = totalStories - 3; // Show last two articles when at the beginning
    } else if (currentStoryIndex >= totalStories - 1) {
        currentStoryIndex = 0; // Show first two articles when reaching the end
    }

    // Translate the wrapper to show the current set of 2 stories
    storiesWrapper.style.transform = `translateX(-${currentStoryIndex * 50}%)`;
}
function fetchAnnouncements() {
    $.ajax({
        url: 'fetch_announcements.php', // A PHP file that returns the announcements as JSON
        method: 'GET',
        success: function(data) {
            // Parse the JSON response and update the HTML content
            let announcements = JSON.parse(data);
            let announcementList = '';
            announcements.forEach(function(announcement) {
                announcementList += `
                    <li>
                        <h4>${announcement.title}</h4>
                        <p>${announcement.content}</p>
                        <small>Posted on: ${announcement.created_at}</small>
                    </li>
                `;
            });
            document.querySelector('.announcement-list').innerHTML = announcementList;
        }
    });
}

// Set interval to update announcements every 30 seconds
setInterval(fetchAnnouncements, 30000);
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.querySelectorAll(".slides");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3000);
    let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let slides = document.querySelectorAll(".slides");
    let dots = document.querySelectorAll(".dot");

    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }

    slides.forEach(slide => slide.style.display = "none");
    dots.forEach(dot => dot.classList.remove("active"));

    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].classList.add("active");
}

}

</script>


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
</body>
</html>
