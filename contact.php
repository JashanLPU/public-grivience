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
    <title>Contact Us - CivicPulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to the specific CSS for this page -->
    <link rel="stylesheet" href="contact.css">
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
                <a href="archive.php" >Resolved Grievance</a>
                <a href="contact.php" class="active">Contact Us</a>
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
    <main class="contact-main">
        <!-- Page Title Section -->
        <section class="page-title-section">
            <div class="page-title-content">
                <h2>Get In Touch</h2>
                <p>Have a question, suggestion, or need support? We're here to help. Reach out to us through the form below or using our contact details.</p>
            </div>
        </section>

        <!-- Contact Container -->
        <section class="contact-content-section">
            <div class="contact-container">
                <!-- Left Side: Contact Form -->
                <div class="contact-form-wrapper animate-on-scroll">
                    <form action="#" method="POST" class="contact-form">
                        <h3>Send us a Message</h3>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>

                <!-- Right Side: Contact Info -->
                <div class="contact-info-wrapper animate-on-scroll delay-1">
                    <h3>Contact Information</h3>
                    <p>You can also reach us directly through the following channels. We look forward to hearing from you.</p>
                    <div class="info-item">
                        <i class="fa-solid fa-map-marker-alt"></i>
                        <div>
                            <h4>Address</h4>
                            <p>123 Civic Center, Model Town, Jalandhar, Punjab, India</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>support@civicpulse.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fa-solid fa-phone"></i>
                        <div>
                            <h4>Phone</h4>
                            <p>+91 123 456 7890</p>
                        </div>
                    </div>
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

    <script src="home.js"></script> <!-- Reusing the animation script -->
<div id="notification" class="notification"></div>
</body>
</html>
