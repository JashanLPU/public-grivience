<?php
// --- Update Grievance API Endpoint ---

header('Content-Type: application/json');
require 'config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($id > 0 && !empty($action)) {
        
        if ($action == 'upvote') {
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
        // --- FIXED: 'resolve' action ---
        elseif ($action == 'resolve') {
            // This query now also sets the 'resolved_at' timestamp to the current time.
            $stmt = $conn->prepare("UPDATE grievances SET status = 'resolved', resolved_at = NOW() WHERE id = ?");
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
