<?php
// submit_admission.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $course = htmlspecialchars($_POST['course']);
    $dob = htmlspecialchars($_POST['dob']);
    $address = htmlspecialchars($_POST['address']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($course) || empty($dob) || empty($address)) {
        echo "All fields are mandatory. Please go back and fill out the form completely.";
    } else {
        // Prepare and bind statement
        $stmt = $conn->prepare("INSERT INTO students (name, email, phone, course, dob, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $course, $dob, $address);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Thank you for registering! We will contact you shortly.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
