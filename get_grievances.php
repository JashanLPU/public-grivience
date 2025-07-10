<?php
// --- Get Grievances API Endpoint ---
// This script fetches all pending grievances from the database,
// sorts them by priority, and sends them to the frontend as JSON.

// Set the header to indicate that the response will be in JSON format.
header('Content-Type: application/json');

// Include our database configuration file to get the $conn object.
require 'config.php';

// --- Prepare SQL Query ---
// We select all columns from the `grievances` table.
// We only want to show issues that are still 'pending'.
// The ORDER BY clause is crucial:
// - `severity DESC`: Sorts by severity in descending order (4, 3, 2, 1), so critical issues are first.
// - `upvotes DESC`: For grievances with the same severity, the one with more upvotes comes first.
// This SQL query acts as our "Sorted Linked List" logic on the backend.
$sql = "SELECT * FROM grievances WHERE status = 'pending' ORDER BY severity DESC, upvotes DESC";

// Execute the query.
$result = $conn->query($sql);

// Initialize an array to hold our grievance data.
$grievances = array();

// --- Process the Results ---
// Check if the query returned any rows.
if ($result->num_rows > 0) {
    // Loop through each row of the result set.
    // The `fetch_assoc()` method gets one row at a time as an associative array.
    while($row = $result->fetch_assoc()) {
        // Add (push) the row (which is a grievance) into our $grievances array.
        $grievances[] = $row;
    }
}

// Close the database connection.
$conn->close();

// --- Send Response ---
// Encode the final array of grievances into a JSON string and echo it back.
// If there were no grievances, this will be an empty array [].
echo json_encode($grievances);

?>
