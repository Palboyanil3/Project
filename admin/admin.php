<?php
session_start();
// Check if the admin is already logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to the login page if not logged in
    exit();
}
include '../server/db.php';

// Fetch notices from the database
$notices_sql = "SELECT * FROM notices ORDER BY date_posted DESC";
$notices_result = $conn->query($notices_sql);

// Fetch upcoming test schedule
$upcoming_tests_sql = "SELECT * FROM upcoming_tests ORDER BY test_date ASC";
$upcoming_tests_result = $conn->query($upcoming_tests_sql);

// Fetch competitive exams
$our_courses_sql = "SELECT * FROM our_courses";
$our_courses_result = $conn->query($our_courses_sql);
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="container">
<main class="main-content">
        <h3>Add Any Updates</h3>
        <a href="update_notices.php" ><i class="fas fa-plus-circle"></i> Add Notice</a>
        <a href="update_tests.php"><i class="fas fa-plus-circle"></i> Add Exam Update</a>
        <a href="update_courses.php"><i class="fas fa-plus-circle"></i> Add Course </a>
    </main>

    <div class="main-content">
    <h1>Manage Updates</h1>
    <div class="card">
        <h3>Manage Notices</h3>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Notice Title</th>
                    <th>Notice Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($notice = $notices_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($notice['notice_title']); ?></td>
                        <td><?php echo htmlspecialchars($notice['notice_content']); ?></td>
                        <td>
                            <a href="edit_notice.php?notice_id=<?php echo $notice['id']; ?>">Edit</a> | 
                            <a href="assets/delete_notice.php?id=<?php echo $notice['id']; ?>" onclick="return confirm('Are you sure you want to delete this notice?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Manage Upcoming Test Schedules</h3>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Test Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($test = $upcoming_tests_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                        <td><?php echo date("F j, Y", strtotime($test['test_date'])); ?></td>
                        <td>
                            <a href="edit_test.php?test_id=<?php echo $test['id']; ?>">Edit</a> | 
                            <a href="assets/delete_test.php?id=<?php echo $test['id']; ?>" onclick="return confirm('Are you sure you want to delete this test?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Manage Competitive Exams</h3>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($exam = $our_courses_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exam['course_name']); ?></td>
                        <td>
                            <a href="edit_course.php?course_id=<?php echo $exam['id']; ?>">Edit</a> | 
                            <a href="assets/delete_course.php?id=<?php echo $exam['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
 </style>

</div>

<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
