<?php
// --- User Registration API Endpoint ---
// This script handles the signup process.

header('Content-Type: application/json');
require 'config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get data from the signup form
    $fullName = isset($_POST['name']) ? $_POST['name'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // --- Validate Input ---
    if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email format.';
    } else {
        
        // --- Check for existing user ---
        // We must ensure the username and email are unique.
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Username or email already exists.';
        } else {
            // --- Securely Hash the Password ---
            // This is the most important step for security.
            // We never store plain text passwords.
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // --- Insert New User ---
            $insert_stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $fullName, $username, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Registration successful! You can now log in.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Registration failed. Please try again.';
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);

?>
