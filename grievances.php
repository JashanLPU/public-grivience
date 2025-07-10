<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in.
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['username'] : '';

// A user must be logged in to view this page.
// If not, we redirect them to the login page.
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
    <title>Live Grievances - CivicPulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to your main CSS file -->

    <!-- Link to a new, specific CSS file for this page -->
    <link rel="stylesheet" href="grievances.css">
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
                <a href="grievances.php" class="active">Live Grievances</a>
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
         MAIN CONTENT
    ================================== -->
    <main class="grievance-tool-main">
        <!-- Left Column: Form and Resolved Panel -->
        <aside class="left-panel">
            <!-- Grievance Submission Form -->
            <section class="form-container card">
                <h3><i class="fa-solid fa-bullhorn"></i> Report a New Grievance</h3>
                <form id="grievance-form">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" placeholder="e.g., Large Pothole on College Road" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Provide more details..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="e.g., Near Model Town Market" required>
                    </div>
                    <div class="form-group">
                        <label>Severity</label>
                        <div class="severity-options">
                            <label><input type="radio" name="severity" value="4" checked> Critical</label>
                            <label><input type="radio" name="severity" value="3"> High</label>
                            <label><input type="radio" name="severity" value="2"> Medium</label>
                            <label><input type="radio" name="severity" value="1"> Low</label>
                        </div>
                    </div>
                    <button type="submit" class="submit-grievance-btn">Submit Grievance</button>
                </form>
            </section>

            <!-- Recently Resolved Panel -->
            <section class="resolved-container card">
                 <h3><i class="fa-solid fa-check-double"></i> Recently Resolved</h3>
                 <div id="resolved-list">
                    <!-- Items will be added by JavaScript -->
                 </div>
            </section>
        </aside>

        <!-- Right Column: Live Grievances Board -->
        <section class="grievance-board">
            <h2 class="section-title-alt">Live Grievances (Sorted by Priority)</h2>
            <div id="grievance-list">
                <!-- Grievance cards will be dynamically inserted here by JavaScript -->
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

    <!-- Link to the JavaScript file for this page -->
    <script src="grievances.js"></script>

</body>
</html>
