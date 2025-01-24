<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $stmt = $conn->prepare("SELECT * FROM user_create WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];  // Ensure this is set

            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['message'] = "Invalid password!";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "No user found with that username!";
        header("Location: ../login.php");
        exit();
    }
}
?>
