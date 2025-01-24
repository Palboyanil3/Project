<?php
session_start(); // Start the session
?>
<header>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo"><a href="#">IDEAL INSTITUTE</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#">IDEAL INSTITUTE</a></span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>

                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="About.php">About Us</a></li>
                    <li><a href="Courses.php">Courses</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <!-- Show welcome message and logout button -->
                        <li>
                            <span id="username" style="cursor: pointer;">
                            <li><a href="User/student_dashboard.php">Student </a></li>
                                <?php echo htmlspecialchars($_SESSION['username']); ?>!&nbsp;
                                <img src="image/logout.png" alt="Logo" style="width: 17px; height: 16px;" id="userImage">
                            </span>
                        </li>
                        <!-- Popup content -->
                        <div id="popup" class="popup">
                            <ul>
                                <li><a href="server/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Show Login and Register buttons -->
                        <button data-toggle="modal" data-target="#loginModal">Log in</button>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </nav>
</header>

<!-- Login Modal -->
<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="server/login_process.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <a href="Login.php">Don't have an account? Please Register!</a><br></br>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/navbar.js"></script>
</div>

<!-- Add the necessary Bootstrap JS CDN -->

<!-- Add Custom JS for Popup Functionality -->
<script>
    function showPopup(event) {
        var popup = document.getElementById('popup');

        // Toggle popup visibility
        if (popup.style.display === 'none' || popup.style.display === '') {
            var rect = event.target.getBoundingClientRect();

            // Position the popup near the image or username
            popup.style.top = rect.top + window.scrollY + 30 + 'px'; // 30px offset for better placement
            popup.style.left = rect.left + window.scrollX + 'px';

            popup.style.display = 'block';
        } else {
            popup.style.display = 'none';
        }
    }

    // When username click show profile and logout button 
    document.getElementById('userImage').addEventListener('click', showPopup);
    document.getElementById('username').addEventListener('click', showPopup);

    // Hide the popup when clicking outside
    document.addEventListener('click', function(event) {
        var popup = document.getElementById('popup');
        var image = document.getElementById('userImage');
        var username = document.getElementById('username');

        if (!popup.contains(event.target) && event.target !== image && event.target !== username) {
            popup.style.display = 'none';
        }
    });
</script>

<!-- Add Custom CSS for Popup -->
<style>
    .popup {
        display: none;
        position: absolute ;
        background-color: white;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .popup ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .popup ul li {
        padding: 5px;
        margin: 5px 0;
    }

    .popup ul li a {
        text-decoration: none;
        color: black;
    }

    .popup ul li a:hover {
        color: blue;
    }
</style>
