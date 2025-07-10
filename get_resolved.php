<?php
// --- Get Recently Resolved API Endpoint ---

// --- FIXED: Added headers to prevent browser caching ---
// This ensures that every time we ask for the list, we get the freshest data from the database.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: application/json');

require 'config.php';

// This query sorts by the new 'resolved_at' column to get the 5 most RECENTLY resolved items.
$sql = "SELECT * FROM grievances WHERE status = 'resolved' ORDER BY resolved_at DESC LIMIT 5";

$result = $conn->query($sql);

$resolved_grievances = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $resolved_grievances[] = $row;
    }
}

$conn->close();

echo json_encode($resolved_grievances);

?>
