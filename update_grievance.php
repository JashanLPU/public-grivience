<?php
// --- Update Grievance API Endpoint ---
// This script handles two actions: 'upvote' and 'resolve'.
// It receives a grievance ID and the action to perform.

header('Content-Type: application/json');
require 'config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the grievance ID and the action from the POST request.
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($id > 0 && !empty($action)) {
        
        // --- Handle 'upvote' action ---
        if ($action == 'upvote') {
            // This query safely increments the 'upvotes' count for a specific grievance ID.
            // Using `upvotes = upvotes + 1` is an atomic operation in MySQL, which is safe.
            $stmt = $conn->prepare("UPDATE grievances SET upvotes = upvotes + 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Grievance upvoted successfully!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to upvote grievance.';
            }
            $stmt->close();
        } 
        // --- Handle 'resolve' action ---
        elseif ($action == 'resolve') {
            // This query changes the status of a grievance from 'pending' to 'resolved'.
            $stmt = $conn->prepare("UPDATE grievances SET status = 'resolved' WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Grievance resolved successfully!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to resolve grievance.';
            }
            $stmt->close();
        } 
        // --- Handle invalid action ---
        else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid action specified.';
        }

    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid ID or action.';
    }

} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);

?>
