<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in.
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['username'] : '';

// A user must be logged in to view this page.
if (!$is_logged_in) {
    header("location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolved Archive - CivicPulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- FIXED: Linking ONLY to the dedicated archive.css file -->
    <link rel="stylesheet" href="archive.css">
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
                <a href="about.php">About Us</a>
                <a href="grievances.php">Live Grievances</a>
                <a href="archive.php" class="active">Resolved Grievance</a>
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
    <main class="archive-main">
        <div class="archive-header">
            <h1>Resolved Grievance Archive</h1>
            <p>A complete and transparent record of all issues that have been successfully resolved by city officials.</p>
        </div>
        <div id="archive-list" class="archive-list">
            <!-- Resolved grievance cards will be dynamically inserted here by archive.js -->
        </div>
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

    <!-- Link to the JavaScript file for this page -->
    <script src="archive.js"></script>

</body>
</html>
