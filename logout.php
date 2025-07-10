<?php
// --- User Logout Script ---
// This script destroys the user's session and logs them out.

// 1. Initialize the session
session_start();

// 2. Unset all of the session variables.
// This clears all the data we stored when the user logged in.
$_SESSION = array();

// 3. Destroy the session.
// This completely ends the session.
session_destroy();

// 4. Redirect to login page.
// After logging out, we send the user back to the main login page.
header("location: index.html");
exit;
?>
