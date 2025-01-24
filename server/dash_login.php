<?php
session_start(); // Start the session

include 'db.php';  // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT * FROM user_create WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if password matches
        if (password_verify($password, $user['password'])) {
            // Login success, set session and redirect
            $_SESSION['username'] = $user['username'];
            header("Location: ../User/dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid password!";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "No user found with that username!";
        header("Location: ../login.php");
        exit();
    }
}
?>
