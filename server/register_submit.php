<?php
// register_submit.php - Process the form submission and insert the data into the database

// Include the database connection (uses MySQLi)
include('db.php');  // Adjust the path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $message = $_POST['message'];

    // Prepare the SQL query to insert the data
    $sql = "INSERT INTO admissions (name, email, phone, course, message) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement using MySQLi
    if ($stmt = $conn->prepare($sql)) {

        // Bind the parameters to the statement
        $stmt->bind_param("sssss", $name, $email, $phone, $course, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the thank you page after successful submission
            header("Location: register_thankyou.php");
            exit();
        } else {
            echo "<p>Error executing query: " . $stmt->error . "</p>"; // MySQLi-specific error handling
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p>Error preparing query: " . $conn->error . "</p>"; // MySQLi-specific error handling
    }

    // Close the database connection
    $conn->close();
}
?>
