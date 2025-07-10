<?php

session_start();

header('Content-Type: application/json');
require 'config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get data from the login form
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // --- Validate Input ---
    if (empty($email) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Please enter both email and password.';
    } else {
        
        // --- Find the User in the Database ---
        // We select the user based on their email address.
        $stmt = $conn->prepare("SELECT id, full_name, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // User found, now verify the password.
            $user = $result->fetch_assoc();
            
            // --- Verify Hashed Password ---
            // The password_verify() function securely compares the submitted password
            // with the hashed password we stored in the database during registration.
            if (password_verify($password, $user['password'])) {
                
                // --- Login Successful: Create Session ---
                // We store the user's information in the $_SESSION superglobal.
                // This data will be available on all other pages as long as the session is active.
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];

                $response['status'] = 'success';
                $response['message'] = 'Login successful!';
                
            } else {
                // If passwords do not match
                $response['status'] = 'error';
                $response['message'] = 'Invalid email or password.';
            }
        } else {
            // If no user was found with that email
            $response['status'] = 'error';
            $response['message'] = 'Invalid email or password.';
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
