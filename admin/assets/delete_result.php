<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include('../../server/db.php');

// Check if the form is submitted and if there are selected IDs
if (isset($_POST['selected_ids'])) {
    $selected_ids = $_POST['selected_ids']; // Array of selected result IDs
    
    // Check if there are selected results
    if (!empty($selected_ids)) {
        // Sanitize the input to prevent SQL injection
        $ids = implode(',', array_map('intval', $selected_ids));

        // Prepare the DELETE query
        $delete_sql = "DELETE FROM test_result WHERE id IN ($ids)";
        
        // Attempt to execute the query
        if ($conn->query($delete_sql) === TRUE) {
            $_SESSION['delete_message'] = "Selected results have been deleted successfully!";
        } else {
            $_SESSION['delete_message'] = "Error: " . $conn->error;
        }
    } else {
        $_SESSION['delete_message'] = "No results selected for deletion.";
    }
} else {
    $_SESSION['delete_message'] = "No results selected for deletion.";
}

// Redirect back to the view results page
header("Location: ../view_results.php");
exit();

// Close the database connection
$conn->close();
?>
