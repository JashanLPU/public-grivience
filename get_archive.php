<?php
// --- Get Archive API Endpoint ---
// This script fetches ALL resolved grievances from the database.

header('Content-Type: application/json');
require 'config.php';

// This SQL query selects all resolved items, with the most recently resolved first.
$sql = "SELECT * FROM grievances WHERE status = 'resolved' ORDER BY resolved_at DESC";

$result = $conn->query($sql);

$archive_grievances = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $archive_grievances[] = $row;
    }
}

$conn->close();

echo json_encode($archive_grievances);

?>
