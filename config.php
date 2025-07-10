<?php
// --- Database Configuration ---
// This file contains the settings for connecting to the MySQL database.

// Database host, usually 'localhost' when using XAMPP
define('DB_HOST', 'localhost');

// Your MySQL database username, default for XAMPP is 'root'
define('DB_USER', 'root');

// Your MySQL database password, default for XAMPP is empty ''
define('DB_PASS', ''); // <-- IMPORTANT: Change this only if you have set a password for MySQL

// The name of the database we created in Step 1
define('DB_NAME', 'civicpulse_db');

// --- Create Connection ---
// This line creates the actual connection object.
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// --- Check Connection ---
// This is a safety check. If the connection fails for any reason,
// the script will stop and show an error.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to support all languages and emojis correctly.
$conn->set_charset("utf8mb4");

?>
