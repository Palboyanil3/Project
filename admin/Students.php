<?php
session_start();  // Start session

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to the login page if not logged in
    exit();
}

$username = $_SESSION['username'];  // Get the username from session

// Include the database connection file
include '../server/db.php'; 

// Fetch notices from the database
$notices_sql = "SELECT * FROM notices ORDER BY date_posted DESC LIMIT 3";
$notices_result = $conn->query($notices_sql);

// Fetch upcoming test schedule
$upcoming_tests_sql = "SELECT * FROM upcoming_tests ORDER BY test_date ASC LIMIT 3";
$upcoming_tests_result = $conn->query($upcoming_tests_sql);

// Fetch competitive exams
$our_courses_sql = "SELECT * FROM our_courses";
$our_courses_result = $conn->query($our_courses_sql);

?>


<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container">
    <?php include('includes/sidebar.php'); ?>
    <main class="main-content">
        <div class="card">
            
            <h3><img src="user.png" alt="Logo" style="height: 50px;"> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h3>

            <p>Your next test is on <strong>January 20, 2025</strong>.</p>
        </div>
        <div class="card">
            <h3>Notices</h3>
            <ul>
                <?php while($notice = $notices_result->fetch_assoc()): ?>
                    <li><strong><?php echo htmlspecialchars($notice['notice_title']); ?></strong> - <?php echo htmlspecialchars($notice['notice_content']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="card">
            <h3>Upcoming Test Schedule</h3>
            <ul>
                <?php while($test = $upcoming_tests_result->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($test['test_name']); ?> - <?php echo date("F j, Y", strtotime($test['test_date'])); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="card">
            <h3>Our Competitive Exams</h3>
            <p>We prepare students for the following competitive exams:</p>
            <ul>
                <?php while($exam = $our_courses_result->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($exam['course_name']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </main>
</div>

<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
