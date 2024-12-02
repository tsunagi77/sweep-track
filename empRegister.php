<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeID = trim($_POST['employeeID']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($employeeID)) {
        $error_message = "Employee ID is required.";
    } elseif (empty($name)) {
        $error_message = "Name is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO sweepers (employeeID, name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $employeeID, $name, $email, $hashed_password);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['success_message'] = "Registered Successfully!";
            header("Location: empLog.php");
            exit();
        } else {
            $error_message = "Failed to register. Try again.";
            header("Location: empLog.php");
            exit();
        }

        $stmt->close();
    }
}
?>
