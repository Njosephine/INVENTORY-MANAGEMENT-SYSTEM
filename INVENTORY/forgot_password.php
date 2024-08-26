<?php
// Displays errors to help in debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$username = "jose";
$password = "JOSE560jose@#";
$dbname = "INVENTORY";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session to store messages
session_start();

$error = "";
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id FROM USERS WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Email does not exist, set an error message
        $error = "Invalid email address. Please enter a valid email.";
    } else {
       // Email exists, set a success message and redirect
       $_SESSION['message'] = "A password reset token has been sent to your email address.";
       header("Location: reset_password.php");
       exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="overlay">
        <div class="header-container">
            <h2 style="font-size: 14px;">To reset your default or forgotten password, Enter your email
                address that you used to create the account for the system and a password reset
                token will be sent to your email</h2>
        </div>
        <div class="forgot-password-container">
            <form action="" method="post">
                <p>RESET PASSWORD</p>

                <label for="email">Enter your email address</label>
                <input type="email" id="email" name="email" required>
                 <!-- Display error message if email is invalid -->
        <?php if (!empty($error)): ?>
            <span style="color: red; font-size: 0.9em;"><?php echo $error; ?></span>
        <?php endif; ?>

                <button type="submit">REQUEST TOKEN</button>

                <a href="login_page.php" class="back-to-login">Back to Login</a>
            </form>
        </div>
    </div>
</body>

</html>