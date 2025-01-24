<?php
// admission_form.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form</title>
    <link rel="stylesheet" href="css/register.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="container">
        <h2>Enroll Yourself</h2>
        <p>Please complete the registration form to confirm your seat availability. Admission details will be sent to you shortly after registration.</p>
        <form action="server/register_submit.php" method="POST"> <!-- The form will send data to 'submit.php' -->
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="number" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="course">Course Interested:</label>
                <select id="course" name="course">
                    <option value="CAT">CAT (Common Admission Test)</option>
                    <option value="UPSC">UPSC (Union Public Service Commission)</option>
                    <option value="GATE">GATE (Graduate Aptitude Test in Engineering)</option>
                    <option value="SSC">SSC (Staff Selection Commission)</option>
                    <option value="GRE">GRE (Graduate Record Examination)</option>
                    <option value="GMAT">GMAT (Graduate Management Admission Test)</option>
                    <option value="CSIR NET">CSIR NET (Council of Scientific and Industrial Research National Eligibility Test)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" placeholder="Any additional information or queries"></textarea>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
