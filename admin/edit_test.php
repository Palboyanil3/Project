<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php';

// Check if the test ID is provided in the URL
if (isset($_GET['test_id'])) {
    $test_id = $_GET['test_id'];

    // Fetch the test data from the database
    $sql = "SELECT * FROM upcoming_tests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $test = $result->fetch_assoc();
    } else {
        echo "Test not found.";
        exit();
    }
} else {
    echo "No test ID specified.";
    exit();
}

// Update the test if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $test_name = $_POST['test_name'];
    $test_date = $_POST['test_date'];

    // Update query
    $update_sql = "UPDATE upcoming_tests SET test_name = ?, test_date = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $test_name, $test_date, $test_id);
    if ($stmt->execute()) {
        echo "<script>alert('Test updated successfully.'); window.location.href = 'admin.php';</script>";
    } else {
        echo "Error updating test.";
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

        .card h1 {
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
            <h1>Edit Test</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="test_name">Test Name</label>
                    <input type="text" id="test_name" name="test_name" value="<?php echo htmlspecialchars($test['test_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="test_date">Test Date</label>
                    <input type="date" id="test_date" name="test_date" value="<?php echo htmlspecialchars($test['test_date']); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Update Test</button>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="back-btn-container">
            <a href="admin.php" class="back-btn">Back to Tests</a>
        </div>
    </main>
</div>

<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
