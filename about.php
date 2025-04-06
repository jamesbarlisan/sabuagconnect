<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - SABUAG</title>
    <link rel="icon" type="image/png" href="Logos.png">
    <link rel="stylesheet" href="css/about.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<body>
    <div class="objective-container">
    <h2>Main Objectives of SABUAG</h2>
        <ul class="objectives">
            <li>To uphold the ethics of journalism by working for the professionalism and independence of the campus press.</li>
            <li>To promote professionalism of the campus press in the struggle for genuine press freedom.</li>
            <li>To promote understanding and cooperation among organizations and individuals.</li>
        </ul>
</div>
    <div class="about-container">
        <h2>SABUAG Members</h2>
        <div class="members-list">
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '1234', 'members');
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch member data from the database
            $sql = "SELECT first_name, last_name, program, position FROM members";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='member'>";
                    echo "<h3>" . $row['first_name'] . " " . $row['last_name'] . "</h3>";
                    echo "<p><strong>Program:</strong> " . $row['program'] . "</p>";
                    echo "<p><strong>Position:</strong> " . $row['position'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No members registered yet.</p>";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
        <!-- Location Section -->
        <div class="location-container">
        <h2>Our Location</h2>
        <p>Visit us at our office in USTP Panaon, Punta, Panaon, Misamis Occidental 7201.</p>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3933.2819993208577!2d123.83005451428945!3d8.36491390525286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3253c936b3cc45b3%3A0x3a524154a02e5018!2sUniversity%20of%20Science%20and%20Technology%20of%20Southern%20Philippines%20-%20Panaon!5e0!3m2!1sen!2sph!4v1700000000000!5m2!1sen!2sph" 
                width="100%" 
                height="300" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>

</body>
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
    <!-- Slideshow JavaScript -->
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
            setTimeout(showSlides, 4000); // Change slide every 4 seconds
        }

        function currentSlide(n) {
            slideIndex = n - 1;
            showSlides();
        }
    </script>
</body>
</html>
