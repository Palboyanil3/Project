<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../../server/db.php';

// Get the test ID from the URL
if (isset($_GET['id'])) {
    $test_id = $_GET['id'];

    // Prepare SQL to delete the test
    $sql = "DELETE FROM upcoming_tests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $test_id);

    if ($stmt->execute()) {
        echo "<script>alert('Test deleted successfully'); window.location.href='../admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting test'); window.location.href='../admin.php';</script>";
    }
} else {
    echo "<script>alert('Invalid test ID'); window.location.href='../admin.php';</script>";
}

$conn->close();
?>
