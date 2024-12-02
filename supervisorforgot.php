<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['forgot_password_email'])) {
        $email = mysqli_real_escape_string($conn, $_POST['forgot_password_email']);
        
        // Check if email exists
        $stmt = $conn->prepare("SELECT email FROM supervisors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expire_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Store token in the database
            $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expire_time) VALUES (?, ?, ?) 
                                    ON DUPLICATE KEY UPDATE token = ?, expire_time = ?");
            $stmt->bind_param("sssss", $email, $token, $expire_time, $token, $expire_time);
            $stmt->execute();

            // Send reset email
            $reset_link = "http://gmail.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click on this link to reset your password: $reset_link\nThis link is valid for 1 hour.";
            $headers = "From: noreply@gmail.com";

            if (mail($email, $subject, $message, $headers)) {
                $success_message = "Password reset instructions have been sent to your email.";
            } else {
                $error_message = "Failed to send the password reset email. Please try again.";
            }
        } else {
            $error_message = "No user found with that email.";
        }
    }
}
?>
