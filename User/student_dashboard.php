<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

$student_id = $_SESSION['student_id']; // Get student ID from session

// Fetch student details from the database
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);

// Check if the query was prepared successfully
if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
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

        /* Content Styles */
        .container {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
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

        /* Action Links */
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

        h3 {
            color: #333;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'includes/sidebar.php';?>

<!-- Main Content -->
<div class="container">
    <h3>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h3>

    <!-- Profile Card -->
    <div class="card">
        <h4>Your Profile</h4>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
    </div>

    <!-- Latest Notices -->
    <div class="card">
        <h4>Latest Notices</h4>
        <?php
        // Fetch latest notices for the student
        $notices_sql = "SELECT * FROM notices ORDER BY date_posted DESC LIMIT 5";
        $notices_result = $conn->query($notices_sql);

        if ($notices_result->num_rows > 0) {
            while ($notice = $notices_result->fetch_assoc()) {
                echo "<p><strong>" . htmlspecialchars($notice['notice_title']) . "</strong>: " . htmlspecialchars($notice['notice_content']) . "</p>";
            }
        } else {
            echo "<p>No notices available.</p>";
        }
        ?>
    </div>

    <!-- Upcoming Tests -->
    <div class="card">
        <h4>Your Upcoming Tests</h4>
        <?php
        // Fetch upcoming tests for the student
        $upcoming_tests_sql = "SELECT * FROM upcoming_tests ORDER BY test_date ASC LIMIT 3";
        $upcoming_tests_result = $conn->query($upcoming_tests_sql);

        if ($upcoming_tests_result->num_rows > 0) {
            echo "<table class='styled-table'>";
            echo "<thead><tr><th>Test Name</th><th>Test Date</th></tr></thead>";
            echo "<tbody>";
            while ($test = $upcoming_tests_result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($test['test_name']) . "</td><td>" . date("F j, Y", strtotime($test['test_date'])) . "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No upcoming tests.</p>";
        }
        ?>
    </div>

    <!-- Our Courses Section -->
    <div class="card">
        <h4>Our Courses</h4>
        <?php
        // Fetch available courses from the database
        $courses_sql = "SELECT * FROM our_courses ORDER BY course_name ASC";
        $courses_result = $conn->query($courses_sql);

        if ($courses_result->num_rows > 0) {
            echo "<table class='styled-table'>";
            echo "<thead><tr><th>Course Name</th><th>Action</th></tr></thead>";
            echo "<tbody>";
            while ($course = $courses_result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($course['course_name']) . "</td>";
                echo "<td><a href='../register.php?course_id=" . $course['id'] . "'>Enroll</a></td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No courses available at the moment.</p>";
        }
        ?>
    </div>

    <!-- Results Link -->
    <div class="card action-links">
        <h4>Your Results</h4>
        <a href="view_results.php">View All Results</a>
    </div>
</div> <!-- End of container -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
