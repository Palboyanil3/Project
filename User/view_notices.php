<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include database connection file

// Fetch latest notices
$sql = "SELECT * FROM notices ORDER BY date_posted DESC";
$notices_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notices</title>
    <style>
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
            margin-top: 20px;
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
    <?php include 'includes/sidebar.php';?>

    <!-- Main Content -->
    <div class="container">
        <h3>Notices</h3>

        <!-- Notices Table -->
        <div class="card">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Date Posted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($notices_result->num_rows > 0): ?>
                        <?php while ($notice = $notices_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($notice['notice_title']); ?></td>
                                <td><?php echo htmlspecialchars($notice['notice_content']); ?></td>
                                <td><?php echo date("F j, Y", strtotime($notice['date_posted'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No notices available.</td>
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
