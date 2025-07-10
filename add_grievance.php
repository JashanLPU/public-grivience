<?php
// --- Add Grievance API Endpoint ---
// This script receives data from the frontend form and inserts it into the database.

// Set the header to indicate that the response will be in JSON format.
// This is important so our JavaScript can understand the response easily.
header('Content-Type: application/json');

// Include our database configuration file to get the $conn object.
// This is like giving our assistant the key to the filing cabinet.
require 'config.php';

// Initialize an array to hold the JSON response we'll send back.
$response = array();

// Check if the request method is POST. This is a security check to ensure
// data is being sent from our form and not just by someone visiting the URL.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- Get Data from the Frontend ---
    // We use 'isset' to safely check if the variables were sent in the POST request.
    // This prevents errors if the form is submitted incorrectly.
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $severity = isset($_POST['severity']) ? (int)$_POST['severity'] : 0;

    // --- Validate Data ---
    // Basic validation to ensure required fields are not empty.
    if (!empty($title) && !empty($description) && !empty($location) && $severity > 0) {
        
        // --- Prepare SQL Statement ---
        // Using prepared statements is a crucial security measure to prevent SQL injection attacks.
        // We use '?' as placeholders for our data instead of putting the variables directly in the query.
        $stmt = $conn->prepare("INSERT INTO grievances (title, description, location, severity) VALUES (?, ?, ?, ?)");
        
        // Bind the variables to the prepared statement as parameters.
        // 'sssi' tells the database that we are sending three strings and one integer.
        $stmt->bind_param("sssi", $title, $description, $location, $severity);
        
        // --- Execute the Statement ---
        if ($stmt->execute()) {
            // If the insertion was successful, create a success response.
            $response['status'] = 'success';
            $response['message'] = 'Grievance submitted successfully!';
        } else {
            // If there was an error with the insertion, create an error response.
            $response['status'] = 'error';
            $response['message'] = 'Error: Could not save the grievance.';
        }
        
        // Close the statement to free up resources.
        $stmt->close();
        
    } else {
        // If validation fails (e.g., a field was left empty).
        $response['status'] = 'error';
        $response['message'] = 'Invalid input. Please fill all required fields.';
    }
    
} else {
    // If the request method is not POST.
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Close the database connection.
$conn->close();

// --- Send Response ---
// Encode the response array into a JSON string and echo it back to the frontend.
// Our JavaScript will be listening for this response.
echo json_encode($response);

?>
