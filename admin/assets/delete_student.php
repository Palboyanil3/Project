<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../../server/db.php'; // Include database connection file

// Get the student ID from the URL
if (isset($_GET['student_id']) && is_numeric($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
} else {
    // Redirect to view_students.php if no valid student_id is provided
    header("Location: ../view_students.php?error=invalid_id");
    exit();
}

// Prepare and execute delete query
$delete_sql = "DELETE FROM students WHERE id = ?";
$stmt = $conn->prepare($delete_sql);

// Check if the statement is prepared successfully
if ($stmt === false) {
    echo "Error preparing query: " . $conn->error;
    exit();
}

// Bind the student ID to the query
$stmt->bind_param("i", $student_id);

// Execute the query and check for success
if ($stmt->execute()) {
    echo "<script>alert('Student deleted successfully'); window.location.href='../view_students.php';</script>";
} else {
    echo "Error deleting student: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
