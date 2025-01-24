<aside class="sidebar">
    <h1 style="text-transform: uppercase;"><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <ul>
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="admin.php"><i class="fa fa-cogs"></i> Manage Updates</a></li>
        <li><a href="view_results.php"><i class="fa fa-chart-line"></i> Manage Results</a></li>
        <li><a href="view_students.php"><i class="fa fa-users"></i> Manage Students</a></li>
        <li><a href="verify_code.php"><i class="fa fa-lock"></i> Admins Manage</a></li> <!-- Update the icon here -->
        <li><a href="../index.php"><i class="fa fa-globe"></i> Ideal Institute</a></li>
    </ul>
    <div class="logout">
        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</aside>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
