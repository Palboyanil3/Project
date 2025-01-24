<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include '../../server/db.php';

// Check if the admin ID is provided
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Delete the admin from the database
    $sql = "DELETE FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the admin manage page
    header("Location: admin_manage.php");
} else {
    // Redirect if no ID is provided
    header("Location: admin_manage.php");
}

$conn->close();
?>
