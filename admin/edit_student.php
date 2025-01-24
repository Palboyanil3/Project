<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Get student ID from the URL parameter
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

// If no student ID, redirect back to the students view page
if (!$student_id) {
    header("Location: view_students.php");
    exit();
}

// Fetch student details from the database
$sql = "SELECT id, name, email FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit();
}

// Handle form submission for updating student details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update student details in the database
    $update_sql = "UPDATE students SET name = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $name, $email, $student_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Student details updated successfully'); window.location.href='view_students.php';</script>";
    } else {
        echo "Error updating student details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>

    <!-- CSS Styles -->
    <style>
        /* Styling for the page */
       
        .form-group {
            
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
   <?php include 'includes/header.php';?>
   <?php include 'includes/navbar.php';?>
   <?php include 'includes/sidebar.php';?>

    <!-- Main Content -->
    <div class="main-content">
        <h3>Edit Student Details</h3>

        
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>

                <button type="submit">Update Student</button>
            </form>
       
    </div> <!-- End of container -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
