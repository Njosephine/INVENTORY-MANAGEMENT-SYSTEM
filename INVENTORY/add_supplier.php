<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$dbname = "INVENTORY";
$username = "jose";
$password = "JOSE560jose@#";

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$message = ''; // Initialize message variable

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $supplier_location = $_POST['supplier_location'];
    $contact_email = $_POST['contact_email'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO SUPPLIERS (supplier_name, supplier_location, contact_email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $supplier_name, $supplier_location, $contact_email);

    if ($stmt->execute()) {
        echo "Supplier added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

