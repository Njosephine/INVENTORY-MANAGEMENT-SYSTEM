<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Database configuration
$servername = "localhost";
$dbname = "INVENTORY";
$username = "jose";
$password = "JOSE560jose@#";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX request to check if the username exists
if (isset($_POST['check_username'])) {
    $username = $_POST['username'];

    $stmt = $conn->prepare("SELECT id FROM USERS WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password FROM USERS WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword);

    // Fetch the result
    if ($stmt->fetch()) {
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct
            $_SESSION['user_id'] = $id;
            header("Location: dashboard.php"); // Redirect to a dashboard page
            exit();
        } else {
            echo "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid username.</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
