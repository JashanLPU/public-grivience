<?php
// --- Get Recently Resolved API Endpoint ---

header('Content-Type: application/json');
require 'config.php';

// --- FIXED: This query now sorts by the new 'resolved_at' column ---
// This guarantees we get the 5 most RECENTLY resolved items.
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
