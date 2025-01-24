<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include the database connection

// Fetch key statistics for the dashboard
$notices_sql = "SELECT COUNT(*) AS total_notices FROM notices";
$notices_result = $conn->query($notices_sql);
$notices_count = $notices_result->fetch_assoc()['total_notices'];

$upcoming_tests_sql = "SELECT COUNT(*) AS total_tests FROM upcoming_tests";
$upcoming_tests_result = $conn->query($upcoming_tests_sql);
$upcoming_tests_count = $upcoming_tests_result->fetch_assoc()['total_tests'];

$courses_sql = "SELECT COUNT(*) AS total_courses FROM our_courses";
$courses_result = $conn->query($courses_sql);
$courses_count = $courses_result->fetch_assoc()['total_courses'];

$students_sql = "SELECT COUNT(*) AS total_students FROM students";
$students_result = $conn->query($students_sql);
$students_count = $students_result->fetch_assoc()['total_students'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- CSS Styles -->
    <style>
        .dashboard-widget {
            background-color: #f9f9f9;
            padding: 20px;
            border: 3px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }

        .dashboard-widget h4 {
            margin-bottom: 10px;
        }

        .dashboard-widget .count {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dashboard-widget .btn {
            margin-top: 10px;
        }

        .card {
            margin-bottom: 20px;
        }

        .quick-actions a {
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            display: inline-block;
        }

        .quick-actions a.btn-success {
            background-color: #28a745;
        }

        .quick-actions a.btn-warning {
            background-color: #ffc107;
        }

        .quick-actions a.btn-info {
            background-color: #17a2b8;
        }

        .quick-actions a.btn-danger {
            background-color: #dc3545;
        }

        .quick-actions a:hover {
            opacity: 0.8;
        }

        .list-group-item {
            font-size: 16px;
        }

        .list-group-item a {
            font-weight: bold;
            color: #007bff;
        }

        .list-group-item a:hover {
            text-decoration: underline;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            width: 23%;
        }

        .col-md-12 {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <h3 style="text-transform: uppercase;">Welcome Admin, <?php echo htmlspecialchars($_SESSION['username']); ?></h3>

        <!-- Dashboard Widgets -->
        <div class="row">
            <div class="card">
                <div class="card dashboard-widget">
                    <h4>Total Notices</h4>
                    <p class="count"><?php echo $notices_count; ?></p>
                    <a href="update_notices.php" class="btn btn-primary">Manage Notices</a>
                </div>
            </div>

            <div class="card">
                <div class="card dashboard-widget">
                    <h4>Upcoming Tests</h4>
                    <p class="count"><?php echo $upcoming_tests_count; ?></p>
                    <a href="update_tests.php" class="btn btn-primary">Manage Tests</a>
                </div>
            </div>

            <div class="card">
                <div class="card dashboard-widget">
                    <h4>Total Courses</h4>
                    <p class="count"><?php echo $courses_count; ?></p>
                    <a href="update_courses.php" class="btn btn-primary">Manage Courses</a>
                </div>
            </div>

            <div class="card">
                <div class="card dashboard-widget">
                    <h4>Total Students</h4>
                    <p class="count"><?php echo $students_count; ?></p>
                    <a href="view_students.php" class="btn btn-primary">View Students</a>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h3>Recent Activities</h3>
                    <ul class="list-group">
                        <!-- Example of recent activities (e.g., recent test added, notice posted, etc.) -->
                        <li class="list-group-item">New Notice Added: <a href="#">Important Updates</a></li>
                        <li class="list-group-item">Test Schedule Updated: <a href="#">Mathematics Test</a></li>
                        <li class="list-group-item">New Course Added: <a href="#">Java Programming</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h3>Quick Actions</h3>
                    <div class="quick-actions">
                        <a href="update_notices.php" class="btn btn-success">Add Notice</a>
                        <a href="update_tests.php" class="btn btn-warning">Add Test</a>
                        <a href="update_courses.php" class="btn btn-info">Add Course</a>
                        <a href="view_results.php" class="btn btn-danger">View Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End of container -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
