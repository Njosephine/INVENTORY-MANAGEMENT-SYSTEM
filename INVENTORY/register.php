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

// Start session
session_start();

// Debugging: Output session data to check if the error message is set
var_dump($_SESSION);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT id FROM USERS WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Set the error message in session
        $_SESSION['error'] = "Username already exists.";
        // Redirect to the registration page
        header("Location: registers.php");
        exit();
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the insert query
        $stmt = $conn->prepare("INSERT INTO USERS (firstname,lastname,email,username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $hashedPassword);

        if ($stmt->execute()) {
           // Set the success message in session
           $_SESSION['success'] = "Registration successful! Please log in.";
           // Redirect to the login page
           header("Location: login_page.php");
           exit();
        } else {
            // Handle error if insert fails
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>



