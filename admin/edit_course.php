<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Fetch the course ID from the URL parameter and ensure it's a valid integer
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : null;

// Debugging: Check if course_id is received correctly
echo "Course ID: " . $course_id . "<br>";  // Debugging output

// If the course ID is not set or is invalid, show an error message and redirect
if ($course_id === null || $course_id <= 0) {
    echo "<script>alert('Invalid course ID'); window.location.href='admin.php';</script>";
    exit();
}

// Fetch the course details from the database
$sql = "SELECT * FROM our_courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the course exists
if ($result->num_rows == 0) {
    echo "<script>alert('Course not found'); window.location.href='admin.php';</script>";
    exit();
}

$course = $result->fetch_assoc();

// Handle form submission for updating the course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];

    // Debugging: Check if course_name is valid
    echo "Course Name: " . $course_name . "<br>";  // Debugging output

    // Update the course in the database
    $sql_update = "UPDATE our_courses SET course_name = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt_update->bind_param("si", $course_name, $course_id);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('Course updated successfully'); window.location.href='admin.php';</script>";
    } else {
        // Log error
        error_log("Error updating course: " . $stmt_update->error);
        echo "<script>alert('Course update failed'); window.location.href='admin.php';</script>";
    }

    // Close the prepared statement
    $stmt_update->close();
}

// Close the database connection
$conn->close();
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>
<?php include('includes/sidebar.php'); ?>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            align-items:center;
            width: 80%;
            margin: 30px auto;
        }

        .main-content {
            padding: 20px;
        }

        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: 600;
            color: #555;
        }

        .form-group input {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <main class="main-content">
        <div class="card">
            <h3 class="card-title">Edit Course</h3>
            <form method="POST" action="" class="course-form">
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required class="input-field">
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Update Course</button>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="back-btn-container">
            <a href="admin.php" class="back-btn">Back to Courses</a>
        </div>
    </main>
</div>

<?php include('includes/footer.php'); ?>
