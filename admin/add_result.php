<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include('../server/db.php');

// Fetch all students to display in the dropdown
$students_sql = "SELECT id, name FROM students";
$students_result = $conn->query($students_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $test_date = $_POST['test_date'];

    // Fetch student name based on the selected student ID
    $student_name_sql = "SELECT name FROM students WHERE id = ?";
    $stmt = $conn->prepare($student_name_sql);
    $stmt->bind_param("i", $student_id);  // Bind the student_id parameter
    $stmt->execute();
    $stmt->bind_result($student_name);
    $stmt->fetch();
    $stmt->close();

    if ($student_name) {
        // Use prepared statement to insert the result into the database
        $insert_sql = $conn->prepare("INSERT INTO test_result (student_id, student_name, subject, marks, test_date) VALUES (?, ?, ?, ?, ?)");
        $insert_sql->bind_param("issis", $student_id, $student_name, $subject, $marks, $test_date); // Bind parameters to the SQL query
        
        if ($insert_sql->execute()) {
            echo "<p>Result added successfully!</p>";
        } else {
            echo "<p>Error: " . $insert_sql->error . "</p>";
        }

        $insert_sql->close();
    } else {
        echo "<p>Student not found!</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Test Result</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .main-content {
            margin-top: 20px;
        }
        .action-btn {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .styled-table th, .styled-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .styled-table th {
            background-color: #f2f2f2;
        }
        .card {
            margin-bottom: 20px;
        }
        .form-container {
            margin-top: 30px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<div class="container">
    <main class="main-content">
        <h1>Enter Test Result</h1>
        
        <form method="POST" action="add_result.php" class="form-container">
            <label for="student_id">Student:</label>
            <select name="student_id" required>
                <?php
                if ($students_result->num_rows > 0) {
                    while ($student = $students_result->fetch_assoc()) {
                        echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['name']) . "</option>";
                    }
                } else {
                    echo "<option>No students found</option>";
                }
                ?>
            </select>

            <label for="subject">Subject:</label>
            <input type="text" name="subject" required>

            <label for="marks">Marks:</label>
            <input type="number" name="marks" required>

            <label for="test_date">Test Date:</label>
            <input type="date" name="test_date" required>

            <input type="submit" value="Add Result">
        </form>
    </main>
</div>
<div class="container">
    <?php include('includes/sidebar.php'); ?>
    <main class="main-content">
        <h3>Add New Test Result</h3>     
        <div class="card">
            <a href="view_results.php" class="action-btn">
                <i class="fas fa-eye"></i> View Results
            </a>
        </div>     
    </main>
</div>
<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
