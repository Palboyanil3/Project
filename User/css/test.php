<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Get the student ID from session
$student_id = $_SESSION['student_id'];

// Fetch the student's test results from the `test_result` table
$sql = "SELECT students.name, test_result.subject, test_result.marks 
        FROM test_result 
        INNER JOIN students ON test_result.student_id = students.id
        WHERE test_result.student_id = ? 
        ORDER BY test_result.subject ASC";

// Prepare the query and bind parameters
$stmt = $conn->prepare($sql);

// Check if the statement is prepared successfully
if ($stmt === false) {
    echo "Error preparing query: " . $conn->error;
    exit();
}

// Bind the student ID to the query
$stmt->bind_param("i", $student_id);

// Execute the query
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <!-- Add your CSS styles here -->
</head>
<body>

<!-- Student Results Table -->
<h3>My Test Results</h3>
<table border="1">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Subject</th>
            <th>Marks</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['marks']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No results found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Back Button -->
<a href="student_panel.php">Back to Dashboard</a>

</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
