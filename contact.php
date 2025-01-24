<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact us</title>
   <?php include 'includes/head.php'; ?>
</head>
<body>
  <?php include 'includes/header.php'; ?>
  <script>
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      navLinks.classList.toggle('active');
    }
  </script>
      <div class="container-con">
        <div class="contact-info">
            <div>
                <h3>Our Address</h3>
                <p>Old neolife hospital near swaminarayan temple mandvi Kutch 360465</p>
            </div>
            <div>
                <h3>Contact Number</h3>
                <p>+91 8511977534</p>
            </div>
            <div>
                <h3>E-Mail</h3>
                <p>Support@ideal.com</p>
            </div>
        </div>
        
        <div class="form-container">
            <h3>Get in Touch</h3>
            <form action="includes/submit_form.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required></textarea>
    
    <input type="submit" value="Send Message">
</form>

        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
