<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include the database connection file

// Add a new course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];

    // Insert the new course into the database
    $sql = "INSERT INTO courses (course_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_name);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_courses.php");  // Refresh the page after adding
}

// Edit course
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $sql = "SELECT * FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();
}

// Update course after editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
    $course_name = $_POST['course_name'];
    $course_id = $_POST['course_id'];

    // Update the course name in the database
    $sql = "UPDATE courses SET course_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $course_name, $course_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_courses.php");  // Redirect back after updating
}

// Delete course
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_courses.php");  // Refresh the page after deleting
}

// Fetch all courses
$sql = "SELECT * FROM courses";  // Fetch all courses
$courses_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Courses</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

        .card {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="container">
        <h3>Manage Courses</h3>

        <!-- Add Course Form -->
        <div class="card">
            <h4>Add New Course</h4>
            <form action="admin_courses.php" method="POST">
                <input type="text" name="course_name" placeholder="Course Name" required><br><br>
                <button type="submit" name="add_course">Add Course</button>
            </form>
        </div>

        <!-- Edit Course Form (if editing) -->
        <?php if (isset($course)): ?>
        <div class="card">
            <h4>Edit Course</h4>
            <form action="admin_courses.php" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required><br><br>
                <button type="submit" name="edit_course">Update Course</button>
            </form>
        </div>
        <?php endif; ?>

        <!-- Course List -->
        <div class="card">
            <h4>Course List</h4>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($courses_result->num_rows > 0): ?>
                        <?php while ($course = $courses_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td>
                                    <a href="admin_courses.php?edit=true&id=<?php echo $course['id']; ?>">Edit</a> |
                                    <a href="admin_courses.php?delete=true&id=<?php echo $course['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No courses available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div> <!-- End of container -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
