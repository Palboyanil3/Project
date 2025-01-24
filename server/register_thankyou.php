<?php
// thank_you.php

// Optionally, you can add a message here if you'd like
// But we will display the thank you message via HTML.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            text-align: center;
            padding: 50px;
        }
        .thank-you-message {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
        }
        .redirect-message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
    <script>
        // JavaScript to redirect after 5 seconds
        setTimeout(function() {
            window.location.href = "../index.php";  // Change to your index page
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</head>
<body>
    <div class="thank-you-message">
        <h2>Thank You for Your Registration!</h2>
        <p>Your seat availability will be confirmed soon. Admission details will be sent to you shortly.</p>
    </div>
    
    <div class="redirect-message">
        <p>You will be redirected to the homepage in 5 seconds...</p>
    </div>
</body>
</html>
