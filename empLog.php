<?php
$conn = mysqli_connect('localhost', 'root', '', 'mmda');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $stmt = $conn->prepare("SELECT email, password FROM sweepers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $_GET['password'];
            session_start();
            $_SESSION['email'] = $email;
            header("Location: Homepage.php");
            exit();
        if (!$password) {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with that email.";
    }
}
session_start();
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form with Profile Circle</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="logDesign.css">
</head>
<body>
    <div class="wrapper">
        <div class="profile-circle"></div>
        <form id="login-form" method="POST" action=""><br>
            <?php if (!empty($success_message)): ?>
            <div style="color: green;"><?= $success_message ?></div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div style="color: red;"><?= $error_message ?></div>
            <?php endif; ?>
            <div class="input-field">
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                <input type="email" id="login-email" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="input-field">
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                <span class="eye-icon" id="toggle-login-password"><i class="fas fa-eye-slash"></i></span>
            </div>
            <div class="forget">
                <a href="empforgot.php" id="forgot-password-link">Forgot password?</a>
            </div>
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="empRegister.php" id="show-register">Register</a></p>
            </div>
        </form>
        <form class="hidden" id="register-form" method="POST" action="empRegister.php"><br>
            <?php if (!empty($error_message)): ?>
                <div style="color: red;"><?= $error_message ?></div>
            <?php endif; ?>
            <div class="input-field">
                <span class="input-icon"><i class="fa-solid fa-id-card"></i></span>
                <input type="employeeID" name="employeeID" placeholder="Enter your Employee ID" required>
            </div>
            <div class="input-field">
                <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="name" placeholder="Enter your Full Name" required>
            </div>
            <div class="input-field">
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="input-field">
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" placeholder="Create a password" required>
                <span class="eye-icon" id="toggle-password"><i class="fas fa-eye-slash"></i></span>
            </div>
            <div class="input-field">
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="confirm_password" placeholder="Confirm your password" required>
                <span class="eye-icon" id="toggle-confirm-password"><i class="fas fa-eye-slash"></i></span>
            </div>
            <button type="submit">Register</button>
            <div class="register">
                <p>Already have an account? <a href="log.php">Login</a></p>
            </div>
        </form>
    </div>
    <div id="forgot-password-modal" class="modal">
        <div class="modal-content">
            <h3>Reset Password</h3>
            <p>Enter your email to receive reset instructions.</p>
            <form method="POST" action="forgot.php">
                <input type="email" name="forgot_password_email" placeholder="Enter your email" required>
                <div class="modal-buttons">
                    <button type="submit">Submit</button>
                    <button type="button" id="back-button">Back</button>
                </div>
            </form>
            <?php if (isset($success_message)): ?>
                <div style="color: green;"><?= $success_message ?></div>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div style="color: red;"><?= $error_message ?></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.eye-icon').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    icon.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    input.type = "password";
                    icon.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
            });
        });
        document.getElementById('show-register').addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-form').classList.remove('hidden');
        });
        document.getElementById('show-login').addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('register-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
        });

        document.getElementById('forgot-password-link').addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('forgot-password-modal').style.display = 'flex';
        });

        document.getElementById('forgot-password-submit').addEventListener('click', () => {
            alert('Password reset instructions sent to your email!');
            document.getElementById('forgot-password-modal').style.display = 'none';
        });

        document.getElementById('back-button').addEventListener('click', () => {
            document.getElementById('forgot-password-modal').style.display = 'none';
        });
        document.getElementById('register-form').addEventListener('submit', (e) => {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('password-error').style.display = 'block';
            }
        });
    </script>
</body>
</html>
