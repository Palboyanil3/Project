<?php
session_start();
// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Fetch existing notices if available
$notice_id = isset($_GET['id']) ? $_GET['id'] : null;
$notice = null;
if ($notice_id) {
    $sql = "SELECT * FROM notices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notice = $result->fetch_assoc();
}

// Handle form submission for adding or updating notice
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notice_title = $_POST['notice_title'];
    $notice_content = $_POST['notice_content'];

    if ($notice_id) {
        // Update the existing notice
        $sql = "UPDATE notices SET notice_title = ?, notice_content = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $notice_title, $notice_content, $notice_id);
        $stmt->execute();
        echo "<script>alert('Notice updated successfully'); window.location.href='update_notices.php';</script>";
    } else {
        // Insert a new notice
        $sql = "INSERT INTO notices (notice_title, notice_content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $notice_title, $notice_content);
        $stmt->execute();
        echo "<script>alert('Notice added successfully'); window.location.href='update_notices.php';</script>";
    }
}
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

        .form-group input, .form-group textarea {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
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
            <h3><?php echo $notice_id ? 'Update Notice' : 'Add New Notice'; ?></h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="notice_title">Notice Title:</label>
                    <input type="text" id="notice_title" name="notice_title" value="<?php echo htmlspecialchars($notice['notice_title'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="notice_content">Notice Content:</label>
                    <textarea id="notice_content" name="notice_content" required><?php echo htmlspecialchars($notice['notice_content'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn"><?php echo $notice_id ? 'Update Notice' : 'Add Notice'; ?></button>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="back-btn-container">
            <a href="admin.php" class="back-btn">Back to Notices</a>
        </div>
    </main>
</div>

<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
