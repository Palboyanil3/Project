<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../../server/db.php'; // Include database connection file

// Fetch the course ID from the URL parameter
$course_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($course_id) {
    // Prepare the delete query
    $sql = "DELETE FROM our_courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind the course_id parameter and execute the query
    $stmt->bind_param("i", $course_id);
    $stmt->execute();

    // Check if the course was deleted successfully
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Course deleted successfully'); window.location.href='../admin.php';</script>";
    } else {
        echo "<script>alert('Course not found or deletion failed'); window.location.href='../admin.php';</script>";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "<script>alert('Invalid course ID'); window.location.href='../admin.php';</script>";
}

// Close the database connection
$conn->close();
?>
