<?php
session_start();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <header class="main-header">
        <div class="header-content">
            <a href="home.php" class="logo-link"><h1 class="logo">CivicPulse</h1></a>
            <nav class="main-nav">
                <a href="home.php" class="active">Home</a>
                <a href="about.php">About Us</a>
                <a href="grievances.php">Live Grievances</a>
                <a href="contact.php">Contact</a>
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

    <section class="hero-section">
        <div class="video-background">
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

    <footer class="main-footer">
        <p>&copy; 2025 CivicPulse. A project for our community. All rights reserved.</p>
        <div class="footer-links">
            <a href="about.php">About Us</a> | 
            <a href="contact.php">Contact</a> | 
            <a href="#">Privacy Policy</a>
        </div>
    </footer>

    <!-- =================================
         AI CHATBOT
    ================================== -->
    <div id="chatbot-container">
        <button id="chatbot-toggle-btn" class="chatbot-btn">
            <i class="fa-solid fa-headset icon-closed"></i>
            <i class="fa-solid fa-times icon-open"></i>
        </button>
        <div id="chatbot-window" class="chatbot-window">
            <div class="chatbot-header">
                <h3>CivicPulse AI Assistant</h3>
                <p>Ask me anything about our platform!</p>
            </div>
            <div id="chatbot-messages" class="chatbot-messages">
                <div class="chat-message bot-message">
                    <p>Hello! How can I help you today? You can ask me how to report an issue, what severity levels mean, or anything else about CivicPulse.</p>
                </div>
            </div>
            <div class="chatbot-input-form">
                <input type="text" id="chatbot-input" placeholder="Type your question...">
                <button id="chatbot-send-btn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="home.js"></script>

</body>
</html>
