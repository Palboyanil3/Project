<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to fetch the user
    $stmt = $conn->prepare("SELECT * FROM user_create WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables for successful login
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            // Set a success message in the session
            $_SESSION['message'] = "Login successful! Welcome, $username.";

            // Redirect to the home page or dashboard
            header("Location: ../includes/login.php");
            exit();
        } else {
            // Set an error message in the session for invalid password
            $_SESSION['message'] = "Invalid password!";
            header("Location: ../login.php");
            exit();
        }
    } else {
        // Set an error message in the session for no user found
        $_SESSION['message'] = "No user found with that username!";
        header("Location: ../login.php");
        exit();
    }
}
?>
