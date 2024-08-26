<?php
// Start session to access messages
session_start();

$message = "";

// Check if message is set
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    // Clear the message from the session
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('back.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .reset-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group {
            position: relative;
            margin-bottom: 15px;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            padding-right: 40px; /* Space for the eye icon */
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding is included in the width */
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #333;
            z-index: 10; /* Ensure icon is above the input */
        }

        button {
            width: 100%;
            padding: 7px;
            background-color: #e91e63;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c2185b;
        }

        .sign-in-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>

    <div class="reset-container">

        <?php if (!empty($message)): ?>
            <span style="color: green; font-size: 0.9em;"><?php echo $message; ?></span>
        <?php endif; ?>

        <h2>Reset Password</h2>
        <form action="" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="token">Token</label>
                <input type="text" id="token" name="token" placeholder="Enter your token" required>
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
                <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('new-password')"></i>
                <span id="password-error" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
                <i class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('confirm-password')"></i>
                <span id="confirm-password-error" class="error-message"></span>
            </div>
            <button type="submit">Reset Password</button>
            <div class="sign-in-link">
                <p>Already have an account? <a href="login_page.php">Sign In</a></p>
            </div>
        </form>
    </div>

    <script>
        // Validate password strength
        function validatePassword() {
            const password = document.getElementById('new-password').value;
            const passwordError = document.getElementById('password-error');
            const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?`~])[A-Za-z\d!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?`~]{8,}$/;

            if (!strongPasswordRegex.test(password)) {
                passwordError.textContent = 'Password must be at least 8 characters long and include uppercase, lowercase, a number, and a special character.';
                passwordError.style.display = 'block';
                return false;
            } else {
                passwordError.style.display = 'none';
                return true;
            }
        }

        // Validate password match
        function validatePasswordMatch() {
            const password = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const confirmPasswordError = document.getElementById('confirm-password-error');

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                confirmPasswordError.style.display = 'block';
                return false;
            } else {
                confirmPasswordError.style.display = 'none';
                return true;
            }
        }

        // Validate form
        function validateForm() {
            const isPasswordValid = validatePassword();
            const isPasswordMatch = validatePasswordMatch();
            return isPasswordValid && isPasswordMatch;
        }

        // Toggle password visibility
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.querySelector(`#${inputId} ~ .eye-icon`);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>

</body>

</html>
