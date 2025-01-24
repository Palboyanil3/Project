<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../../server/db.php';

// Get the notice ID from the URL
if (isset($_GET['id'])) {
    $notice_id = $_GET['id'];

    // Prepare SQL to delete the notice
    $sql = "DELETE FROM notices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notice_id);

    if ($stmt->execute()) {
        echo "<script>alert('Notice deleted successfully'); window.location.href='../admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting notice'); window.location.href='../admin.php';</script>";
    }
} else {
    echo "<script>alert('Invalid notice ID'); window.location.href='../admin.php';</script>";
}

$conn->close();
?>
