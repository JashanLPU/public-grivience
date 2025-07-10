<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in. If not, they can still view the page,
// but the header will show the "Login" button.
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['username'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicPulse - Your City's Grievance Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to your main CSS file -->
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <!-- =================================
         HEADER
    ================================== -->
    <header class="main-header">
        <div class="header-content">
            <a href="home.php" class="logo-link"><h1 class="logo">CivicPulse</h1></a>
            <nav class="main-nav">
                <a href="home.php" class="active">Home</a>
                <a href="about.php">About Us</a>
                <a href="grievances.php">Live Grievance</a>
                <a href="contact.php">Contact Us</a>
            </nav>
            <div class="user-actions">
                <?php if ($is_logged_in): ?>
                    <span class="welcome-user">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                    <a href="logout.php" class="logout-btn-header">Logout</a>
                <?php else: ?>
                    <a href="index.html" class="login-btn">Login / Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- =================================
         HERO SECTION
    ================================== -->
    <section class="hero-section">
        <div class="video-background">
            <!-- Video by Taryn Elliott from Pexels -->
            <video autoplay muted loop playsinline poster="placeholder.jpg">
                <source src="https://videos.pexels.com/video-files/853877/853877-hd.mp4" type="video/mp4">
            </video>
        </div>
        <div class="hero-content">
            <h2 class="animate-on-load">Your Voice, Amplified.</h2>
            <p class="animate-on-load delay-1">The new way for citizens to report civic issues, see real-time progress, and build a better community together.</p>
            <div class="animate-on-load delay-2">
                <a href="grievances.php" class="cta-button">View Live Grievances</a>
            </div>
        </div>
    </section>

    <!-- =================================
         FEATURE HIGHLIGHT SECTION
    ================================== -->
    <section class="feature-section">
        <div class="feature-container">
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon"><i class="fa-solid fa-bullhorn"></i></div>
                <h3>Voice Your Concerns</h3>
                <p>Quickly report issues like potholes, water leaks, or waste management problems through our simple form.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-1">
                <div class="feature-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></div>
                <h3>See Real Priorities</h3>
                <p>Our transparent system automatically sorts issues by severity, ensuring the most critical problems get attention first.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-2">
                <div class="feature-icon"><i class="fa-solid fa-square-check"></i></div>
                <h3>Track Progress</h3>
                <p>Follow the status of your reported grievances and see a live feed of resolved issues across the city.</p>
            </div>
        </div>
    </section>

    <!-- =================================
         FOOTER
    ================================== -->
    <footer class="main-footer">
        <p>&copy; 2025 CivicPulse. A project for our community. All rights reserved.</p>
        <div class="footer-links">
            <a href="about.php">About Us</a> | 
            <a href="contact.php">Contact</a> | 
            <a href="#">Privacy Policy</a>
        </div>
    </footer>

    <script src="home.js"></script>

</body>
</html>
