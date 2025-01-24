<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include('../server/db.php');

// Fetch results from the database
$sql = "SELECT test_result.id, students.name AS student_name, test_result.subject, test_result.marks, test_result.test_date
        FROM test_result
        JOIN students ON test_result.student_id = students.id
        ORDER BY test_result.test_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .main-content {
            margin-top: 20px;
        }
        .action-btn {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .styled-table th, .styled-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .styled-table th {
            background-color: #f2f2f2;
        }
        .card {
            margin-bottom: 20px;
        }
        .confirmation-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .popup-content button {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            border: none;
        }
        .popup-content button:hover {
            background-color: #45a049;
        }
        #deleteBtn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        #deleteBtn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<div class="container">
    <?php include('includes/sidebar.php'); ?>
    <main class="main-content">
        <h3>Manage Results</h3>     
        <div class="card">
            <a href="add_result.php" class="action-btn">
                <i class="fas fa-plus"></i> Add Result
            </a>
        </div>     
    </main>
</div>

<div class="container">
    <main class="main-content">
        <h1>Student Results</h1>
        <p>If you want to delete any result, just select and delete</p>

        <!-- Button to delete results, moved to the top -->
        <div class="card">
            <form method="POST" action="assets/delete_result.php" id="deleteForm">
                <input type="button" value="Delete Selected Results" id="deleteBtn">
                
                <!-- Table for results -->
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"> Select All</th>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Date of Exam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td><input type='checkbox' name='selected_ids[]' value='{$row['id']}'></td>
                                        <td>{$row['student_name']}</td>
                                        <td>{$row['subject']}</td>
                                        <td>{$row['marks']}</td>
                                        <td>" . date("F j, Y", strtotime($row['test_date'])) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No results found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </main>
</div>

<!-- Popup Confirmation Modal -->
<div id="confirmationPopup" class="confirmation-popup">
    <div class="popup-content">
        <h3>Are you sure you want to delete the selected results?</h3>
        <button id="confirmDelete">Yes, Delete</button>
        <button id="cancelDelete">Cancel</button>
    </div>
</div>

<script>
    // Select all checkboxes
    document.getElementById("select_all").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById("select_all").checked;
        });
    });

    // Show the popup confirmation on clicking the delete button
    document.getElementById("deleteBtn").addEventListener("click", function() {
        const selectedCheckboxes = document.querySelectorAll('input[name="selected_ids[]"]:checked');
        if (selectedCheckboxes.length > 0) {
            document.getElementById("confirmationPopup").style.display = 'flex';
        } else {
            alert("Please select at least one result to delete.");
        }
    });

    // Confirm deletion
    document.getElementById("confirmDelete").addEventListener("click", function() {
        document.getElementById("deleteForm").submit(); // Submit the form
    });

    // Cancel deletion
    document.getElementById("cancelDelete").addEventListener("click", function() {
        document.getElementById("confirmationPopup").style.display = 'none'; // Close the popup
    });
</script>

<?php include('includes/footer.php'); ?>

<?php
// Close the database connection
$conn->close();
?>
