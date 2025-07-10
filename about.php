<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in.
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - CivicPulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- FIXED: Linking ONLY to the dedicated about.css file -->
    <link rel="stylesheet" href="about.css">
</head>
<body>

    <!-- =================================
         HEADER
    ================================== -->
    <header class="main-header">
        <div class="header-content">
            <a href="home.php" class="logo-link"><h1 class="logo">CivicPulse</h1></a>
            <nav class="main-nav">
                <a href="home.php">Home</a>
                <a href="about.php" class="active">About Us</a>
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

    <!-- =================================
         MAIN CONTENT
    ================================== -->
    <main class="about-main">
        <!-- Page Title Section -->
        <section class="page-title-section">
            <div class="page-title-content">
                <h2>Our Mission: A More Responsive City</h2>
                <p>CivicPulse was born from a simple idea: every citizen's voice matters. We believe that technology, when applied correctly, can bridge the gap between residents and city officials, creating a more transparent, efficient, and collaborative community.</p>
            </div>
        </section>

        <!-- Our Commitment Section -->
        <section class="commitment-section">
            <h3 class="section-title">Our Commitment to You</h3>
            <div class="steps-container">
                <div class="step-card animate-on-scroll">
                    <div class="step-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                    <h4>Fairness</h4>
                    <p>Every report is handled in the order it's received. There's no skipping the line. Your voice is logged and addressed with the fairness it deserves.</p>
                </div>
                <div class="step-card animate-on-scroll delay-1">
                    <div class="step-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <h4>Priority</h4>
                    <p>Our intelligent system automatically identifies the most critical issues. Urgent problems get the immediate attention they need, ensuring safety and well-being.</p>
                </div>
                <div class="step-card animate-on-scroll delay-2">
                    <div class="step-icon"><i class="fa-solid fa-eye"></i></div>
                    <h4>Transparency</h4>
                    <p>You can track the progress of any grievance, from submission to resolution. We provide a clear and open record of all actions taken by city officials.</p>
                </div>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="story-section">
            <div class="story-container">
                <div class="story-image animate-on-scroll">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2070&auto=format=fit=crop" alt="Team working together">
                </div>
                <div class="story-content animate-on-scroll delay-1">
                    <h3 class="section-title-alt">Our Story</h3>
                    <p>CivicPulse started as a competition project with a bold goal: to empower citizens and improve civic engagement through technology. We saw a need for a platform that was not only functional but also fair and transparent.</p>
                    <p>Built on a foundation of robust data structures and user-centric design, our platform is more than just a tool—it's a commitment to our community. We are dedicated to continuous improvement and to fostering a stronger connection between the people and the administration that serves them.</p>
                </div>
            </div>
        </section>

        <!-- Meet the Team Section -->
        <section class="team-section">
            <h3 class="section-title">Meet the Team</h3>
            <div class="team-container">
                <div class="team-member-card animate-on-scroll">
                    <img src="https://placehold.co/400x400/0d9488/ffffff?text=You" alt="Project Lead">
                    <h4>Your Name</h4>
                    <p>Project Lead & Visionary</p>
                </div>
                <div class="team-member-card animate-on-scroll delay-1">
                    <img src="https://placehold.co/400x400/1e293b/ffffff?text=M2" alt="Team Member 2">
                    <h4>Team Member 2</h4>
                    <p>Backend Developer</p>
                </div>
                <div class="team-member-card animate-on-scroll delay-2">
                    <img src="https://placehold.co/400x400/1e293b/ffffff?text=M3" alt="Team Member 3">
                    <h4>UI/UX Designer</h4>
                </div>
                <div class="team-member-card animate-on-scroll delay-3">
                    <img src="https://placehold.co/400x400/1e293b/ffffff?text=M4" alt="Team Member 4">
                    <h4>Database Specialist</h4>
                </div>
                <div class="team-member-card animate-on-scroll delay-4">
                    <img src="https://placehold.co/400x400/1e293b/ffffff?text=M5" alt="Team Member 5">
                    <h4>QA Tester</h4>
                </div>
            </div>
        </section>
    </main>

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
