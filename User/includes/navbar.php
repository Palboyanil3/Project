<?php
// navbar.php - Contains the navigation bar for the site
?>
<header class="navbar">
<!-- other sidebar content -->
<h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <nav>
        <a href="#">Home</a>
        <a href="#">Courses</a>
        <a href="#">Mock Tests</a>
        <a href="#">Performance</a>
        <a href="#">Profile</a>
    </nav>
</header>
