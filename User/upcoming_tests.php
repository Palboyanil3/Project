<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");  // Redirect to login if not logged in
    exit();
}


include '../server/db.php'; // Include database connection file

// Initialize error and success messages
$error_message = '';

// Fetch upcoming tests for the logged-in user from the database
$sql = "SELECT test_name, test_date FROM upcoming_tests ORDER BY test_date ASC";
$stmt = $conn->prepare($sql);

// Check if the query is prepared successfully
if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Upcoming Tests</title>

    <!-- Add your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding-top: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar h1 {
            text-align: center;
            color: #ecf0f1;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
            border-radius: 5px;
        }

        .container {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

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

        h3 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .sidebar ul li a.active {
            background-color: #16a085;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'includes/sidebar.php';?>


<!-- Main Content -->
<div class="container">
    <h3>Upcoming Tests</h3>

    <!-- Display upcoming tests in a table -->
    <table class="styled-table">
        <thead>
            <tr>
                <th>Test Name</th>
                <th>Test Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['test_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['test_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No upcoming tests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
