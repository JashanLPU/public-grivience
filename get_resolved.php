<?php
// --- Get Recently Resolved API Endpoint ---
// This script fetches the 5 most recently resolved grievances from the database.

header('Content-Type: application/json');
require 'config.php';

// This SQL query selects all columns from grievances where the status is 'resolved'.
// It orders them by the creation date in descending order to get the newest ones first.
// LIMIT 5 ensures we only get the top 5 most recent.
$sql = "SELECT * FROM grievances WHERE status = 'resolved' ORDER BY created_at DESC LIMIT 5";

$result = $conn->query($sql);

$resolved_grievances = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $resolved_grievances[] = $row;
    }
}

$conn->close();

// Send the list of resolved grievances back to the frontend as JSON.
echo json_encode($resolved_grievances);

?>
