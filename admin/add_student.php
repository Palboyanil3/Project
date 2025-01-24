<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Handle form submission for adding a student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data from the form
    $student_name = $_POST['name'];
    $student_email = $_POST['email'];
    $student_password = $_POST['password'];

    // Validate inputs (make sure fields are not empty)
    if (empty($student_name) || empty($student_email) || empty($student_password)) {
        $error_message = "All fields are required.";
    } else {
        // Prepare SQL query to insert the student into the database
        $insert_sql = "INSERT INTO students (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);

        // Check if the statement is prepared successfully
        if ($stmt === false) {
            $error_message = "Error preparing query: " . $conn->error;
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($student_password, PASSWORD_DEFAULT);

            // Bind the parameters and execute the query
            $stmt->bind_param("sss", $student_name, $student_email, $hashed_password);
            if ($stmt->execute()) {
                $success_message = "Student added successfully!";
            } else {
                $error_message = "Error adding student: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>

    <!-- Add your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .container {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

       
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group input:focus {
            border-color: #007bff;
        }

        .form-group button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }

        .message.success {
            background-color: #28a745;
        }

        .message.error {
            background-color: #dc3545;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #f39c12;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>
    <!-- Main Content -->
    <div class="container">
        <h3>Add Student</h3>
    <div class="main-content">
        <!-- Display messages -->
        <?php if ($success_message): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php elseif ($error_message): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Student Form -->
        
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input type="text" id="name" name="name" required value="<?php echo isset($student_name) ? htmlspecialchars($student_name) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($student_email) ? htmlspecialchars($student_email) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <button type="submit">Add Student</button>
                </div>
            </form>

        <!-- Back Button -->
        <a href="view_students.php" class="back-button">Back to Students List</a>
     </div>
 </div>

</body>
</html>
