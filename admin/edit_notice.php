<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php';

// Check if the notice ID is provided in the URL
if (isset($_GET['notice_id'])) {
    $notice_id = $_GET['notice_id'];

    // Fetch the notice data from the database
    $sql = "SELECT * FROM notices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notice_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $notice = $result->fetch_assoc();
    } else {
        echo "Notice not found.";
        exit();
    }
} else {
    echo "No notice ID specified.";
    exit();
}

// Update the notice if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notice_title = $_POST['notice_title'];
    $notice_content = $_POST['notice_content'];

    // Update query
    $update_sql = "UPDATE notices SET notice_title = ?, notice_content = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $notice_title, $notice_content, $notice_id);
    if ($stmt->execute()) {
        echo "<script>alert('Notice updated successfully.'); window.location.href = 'admin.php';</script>";
    } else {
        echo "Error updating notice.";
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
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .form-group textarea {
            min-height: 150px;
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
    <?php include('includes/sidebar.php'); ?>
    <main class="main-content">
        <div class="card">
            <h1 class="card-title">Edit Notice</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="notice_title">Notice Title</label>
                    <input type="text" id="notice_title" name="notice_title" value="<?php echo htmlspecialchars($notice['notice_title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="notice_content">Notice Content</label>
                    <textarea id="notice_content" name="notice_content" required><?php echo htmlspecialchars($notice['notice_content']); ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Update Notice</button>
                </div>
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
