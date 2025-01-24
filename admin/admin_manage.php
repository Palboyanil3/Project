<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

include '../server/db.php'; // Include the database connection

// Handle Add Admin Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt the password

    // Insert the new admin into the database
    $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();

    // Set a success message
    $_SESSION['success_message'] = "New admin added successfully!";
}

// Handle Edit Admin Form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_admin'])) {
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Update the admin details in the database
    $sql = "UPDATE admins SET username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $password, $admin_id);
    $stmt->execute();
    $stmt->close();

    // Set a success message
    $_SESSION['success_message'] = "Admin details updated successfully!";
}

// Handle Admin Deletion
if (isset($_GET['delete'])) {
    $admin_id = $_GET['delete'];

    // Delete the admin from the database
    $sql = "DELETE FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->close();

    // Set a success message
    $_SESSION['success_message'] = "Admin deleted successfully!";
}

// Fetch all admins
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);
$admins = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>

    <!-- CSS Styles -->
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f8f9fa;
        }
        .btn {
            padding: 5px 15px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Modal Styles */
        #editModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Overlay */
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure the modal is on top */
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 50%; /* You can adjust the width as needed */
            max-width: 500px;
        }

        .modal-header {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-content button {
            margin-right: 10px;
        }

        .close-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .save-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>
<?php include('includes/sidebar.php'); ?>

    <div class="main-content">
        <h1 class="text-center">Manage Admins</h1>

        <!-- Display Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); // Clear the message after displaying it ?>
            </div>
        <?php endif; ?>

        <!-- Add New Admin Form -->
        <div class="card">
            <h3>Add New Admin</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required class="form-control">
                </div>
                <button type="submit" name="add_admin" class="btn btn-primary">Add Admin</button>
            </form>
        </div>

        <!-- Admin List -->
        <div class="card">
            <h3>Existing Admins</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo $admin['id']; ?></td>
                            <td><?php echo htmlspecialchars($admin['username']); ?></td>
                            <td>
                                <!-- Edit Admin -->
                                <button class="btn btn-warning" onclick="editAdmin(<?php echo $admin['id']; ?>, '<?php echo htmlspecialchars($admin['username']); ?>')">Edit</button>
                                <!-- Delete Admin -->
                                <a href="?delete=<?php echo $admin['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Admin Modal -->
    <div id="editModal">
        <div class="modal-content">
            <div class="modal-header">Edit Admin</div>
            <form id="editForm" method="POST" action="">
                <input type="hidden" name="admin_id" id="edit_admin_id">
                <div class="form-group">
                    <label for="edit_username">Username</label>
                    <input type="text" id="edit_username" name="username" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_password">Password</label>
                    <input type="password" id="edit_password" name="password" required class="form-control">
                </div>
                <button type="submit" name="edit_admin" class="save-btn">Save Changes</button>
                <button type="button" class="close-btn" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- JavaScript to open and close edit modal -->
    <script>
        function editAdmin(id, username) {
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('edit_admin_id').value = id;
            document.getElementById('edit_username').value = username;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</body>
</html>
