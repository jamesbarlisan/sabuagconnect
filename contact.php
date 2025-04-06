<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | SABUAG</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="css/style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
/* Contact Section */
.contact-section {
    padding: 80px 10%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.contact-container {
    display: flex;
    max-width: 1500px;
    padding: 40px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
}

.contact-form {
    flex: 1;
    padding: 20px;
}

/* Vertical Line Divider */
.contact-divider {
    width: 2px;
    background: rgba(0, 0, 0, 0.2);
    height: 100%;
    margin: 0 20px;
}

.contact-info {
    flex: 1;
    padding: 20px;
    text-align: center;
}


.contact-form h2 {
    font-size: 45px;
    color: #1a1851;
    margin-bottom: 10px;
}

.contact-form p {
    font-size: 16px;
    color: #151515;
    margin-bottom: 20px;
}

/* Form Inputs */
.input-group {
    position: relative;
    margin-bottom: 15px;
}

.input-group i {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    color: #1a1851;
    font-size: 16px;
}

.input-group input, 
.input-group textarea {
    width: 100%;
    padding: 12px 15px 12px 35px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: #151515
    outline: none;
}

.input-group input::placeholder, 
.input-group textarea::placeholder {
    color:rgb(107, 107, 107);
}

/* Submit Button */
.contact-form button {
    width: 60%;
    background: #fcb315;
    color: #1a1851;
    padding: 12px;
    border: none;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.contact-form button:hover {
    background: #fff;
    color: #1a1851;
}

/* Contact Info */
.contact-info {
    flex: 1;
    padding: 20px;
    color: #151515;
    text-align: center;
}

.contact-info h3 {
    font-size: 20px;
    margin-bottom: 5px;
}

.contact-info p {
    font-size: 14px;
    margin-bottom: 15px;
}

.contact-info a {
    color: #1a1851;
    text-decoration: none;
    font-weight: bold;
}

.contact-info a:hover {
    text-decoration: underline;
}

/* Social Media Icons */
.social-icons {
    margin-top: 20px;
}

.social-icons a {
    color: #151515;
    font-size: 20px;
    margin: 0 10px;
    transition: 0.3s;
}

.social-icons a:hover {
    color: #fcb315;
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-container {
        flex-direction: column;
        padding: 20px;
    }
}
.modal-success {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-success-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 30px 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    font-size: 18px;
    color: #1a1851;
}

.close-success {
    color: #aaa;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

    </style>
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
<!-- Contact Section -->
<!-- Contact Section -->
<section class="contact-section">
    <div class="contact-container">
        <!-- Left: Contact Form -->
        <div class="contact-form">
            <h2>We'd love to hear from you.</h2>
            <p>Got questions or suggestions? Fill out the form and we'll get back to you soon.</p>

            <form id="contactForm" action="process_form.php" method="POST">
    <div class="input-row">
        <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
        </div>
        <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
        </div>
    </div>
    <div class="input-group">
        <i class="fa fa-envelope"></i>
        <input type="email" id="email" name="email" placeholder="Your Email" required>
    </div>
    <div class="input-group">
        <i class="fa fa-tag"></i>
        <input type="text" id="subject" name="subject" placeholder="Subject" required>
    </div>
    <div class="input-group">
        <i class="fa fa-comment"></i>
        <textarea id="message" name="message" placeholder="Write your message here..." rows="4" required></textarea>
    </div>
    <button type="submit"><i class="fa fa-paper-plane"></i> Send Message</button>
</form>
<!-- Success Modal -->
<div id="successModal" class="modal-success">
    <div class="modal-success-content">
        <span class="close-success">&times;</span>
        <p>Message Sent Successfully!</p>
    </div>
</div>
        </div>
        <!-- Right: Contact Info -->
        <div class="contact-info">
            <h3><i class="fa fa-map-marker"></i> Visit Us</h3>
            <p>University of Science and Technology of <br> Southern Philippines - Panaon Campus, <br> Punta, Panaon, Misamis Occidental, 7205</p>

            <h3><i class="fa fa-phone"></i> Call Us</h3>
            <p>+63 916 500 9028</p>

            <h3><i class="fa fa-envelope"></i> Email</h3>
            <p><a href="mailto:jamesfrancisbarlisan7@gmail.com">jamesfrancisbarlisan7@gmail.com</a></p>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const responseMessage = document.getElementById("responseMessage");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Validate inputs
        const firstName = document.getElementById("first_name").value.trim();
        const lastName = document.getElementById("last_name").value.trim();
        const email = document.getElementById("email").value.trim();
        const subject = document.getElementById("subject").value.trim();
        const message = document.getElementById("message").value.trim();

        if (!firstName || !lastName || !email || !subject || !message) {
            responseMessage.style.color = "red";
            responseMessage.innerHTML = "Please fill in all fields.";
            return;
        }

        // AJAX Request to process_form.php
        let formData = new FormData(form);

        fetch("process_form.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            responseMessage.style.color = data.success ? "green" : "red";
            responseMessage.innerHTML = data.message;
            if (data.success) {
                form.reset(); // Clear form after successful submission
            }
        })
        .catch(error => {
            responseMessage.style.color = "red";
            responseMessage.innerHTML = "An error occurred. Please try again.";
        });
    });
});

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
        document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("successModal");
    const span = document.querySelector(".close-success");

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

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
