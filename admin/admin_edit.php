<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include the database connection

// Handle Edit Admin Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_admin'])) {
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt the password

    // Update the admin details in the database
    $sql = "UPDATE admins SET username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $password, $admin_id);
    $stmt->execute();
    $stmt->close();

    // Set a success message
    $_SESSION['success_message'] = "Admin details updated successfully!";
    header("Location: admin_manage.php"); // Redirect back to the admin management page
    exit();
}

// Retrieve admin details for editing
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Fetch the admin's details
    $sql = "SELECT * FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: admin_manage.php"); // Redirect if no admin ID is provided
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>

    <!-- CSS Styles -->
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn {
            padding: 5px 15px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>
<?php include('includes/sidebar.php'); ?>

    <div class="main-content">
        <h1 class="text-center">Edit Admin</h1>

        <!-- Display Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); // Clear the message after displaying it ?>
            </div>
        <?php endif; ?>

        <!-- Edit Admin Form -->
        <div class="card">
            <h3>Edit Admin Details</h3>
            <form method="POST" action="">
                <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required class="form-control" placeholder="Enter a new password">
                </div>

                <button type="submit" name="edit_admin" class="btn btn-primary">Save Changes</button>
            </form>
        </div>

        <a href="admin_manage.php" class="btn btn-primary">Back to Admin List</a>
    </div>
</body>
</html>
