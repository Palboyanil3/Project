<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php';

// Fetch existing course data if available
$course_id = isset($_GET['id']) ? $_GET['id'] : null;
$course = null;
if ($course_id) {
    $sql = "SELECT * FROM our_courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
}

// Handle form submission for adding or updating course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];

    if ($course_id) {
        // Update the existing course
        $sql = "UPDATE our_courses SET course_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $course_name, $course_id);
        $stmt->execute();
        echo "<script>alert('Course updated successfully'); window.location.href='update_courses.php';</script>";
    } else {
        // Insert a new course
        $sql = "INSERT INTO our_courses (course_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $course_name);
        $stmt->execute();
        echo "<script>alert('Course added successfully'); window.location.href='update_courses.php';</script>";
    }
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }

        .main-content {
            padding: 20px;
        }

        .card {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .course-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .course-form label {
            font-size: 16px;
            font-weight: 600;
            color: #555;
        }

        .input-field {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .submit-btn {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .back-btn-container {
            margin-top: 20px;
            text-align: center;
        }

        .back-btn {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<div class="container">
    <?php include('includes/sidebar.php'); ?>
    <main class="main-content">
        <div class="card">
            <h3 class="card-title"><?php echo $course_id ? 'Update Course' : 'Add New Course'; ?></h3>
            <form method="POST" action="" class="course-form">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name'] ?? ''); ?>" required class="input-field">
                <br><br>
                <button type="submit" class="submit-btn"><?php echo $course_id ? 'Update Course' : 'Add Course'; ?></button>
            </form>
        </div>

        <!-- Back Button -->
        <div class="back-btn-container">
            <a href="admin.php" class="back-btn">Back to Home</a>
        </div>
    </main>
</div>

<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
