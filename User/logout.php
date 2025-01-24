<?php
session_start();  // Start the session

// Destroy all session data
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session

// Redirect to the login page
header("Location: student_login.php");
exit();  // Ensure no further code is executed
?>
