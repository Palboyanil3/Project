<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Fetch students from the database with available columns (id, name, email)
$students_sql = "SELECT id, name, email FROM students ORDER BY name ASC";  // Adjust column names based on your database schema

// Run the query and check for errors
$students_result = $conn->query($students_sql);

// If the query fails, display an error
if (!$students_result) {
    die("Query failed: " . $conn->error); // Display database error
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>

    <!-- CSS Styles -->
    <style>
        /* Styling for the page */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .styled-table th, .styled-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .styled-table th {
            background-color: #34495e;
            color: white;
        }

        .styled-table tr:hover {
            background-color: #f1f1f1;
        }

        .action-links {
            text-align: center;
        }

        .action-links a {
            color: #007bff;
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 5px;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        .add-button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .add-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <?php include('includes/header.php'); ?>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>


    <!-- Main Content -->
    <div class="container">
     <h3>View Students</h3>
     <div class="main-content"> 
        <a href="add_student.php" class="add-button">Add Student</a>
    <div class="card">   
        <h4>Students List</h4>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students_result->num_rows > 0): ?>
                        <?php while ($student = $students_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['id']); ?></td>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td class="action-links">
                                    <a href="edit_student.php?student_id=<?php echo $student['id']; ?>">Edit</a> | 
                                    <a href="assets/delete_student.php?student_id=<?php echo $student['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
       </div>
    </div>

    </div> <!-- End of container -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
