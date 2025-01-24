<!DOCTYPE html>
<html lang="en">
<head>
  <title>IDEAL INSTITUTE</title>
  <?php include 'includes/head.php'; ?>
</head>
<body>
   <div class="top-header">
     <ul class="top-nav-login">
     <li><a href="User/student_login.php"><i class="fas fa-user-graduate"></i> Student Login</a></li>
       <li><a href="admin/Login.php"><i class="fas fa-chalkboard-teacher"></i> Teacher login</a></li>
    </ul>
    <ul class="top-nav-contect">
      <li><a href="tel:+918511977534"><i class="fas fa-phone"></i> +91 8511977734</a></li>
      <li><a href="mailto:support@yourwebsite.com?subject=Support%20Inquiry&body=Hello%2C%20I%20need%20help%20with%20your%20service."><i class="fas fa-envelope"></i> Support@ideal.com</a></li>
    <ul>    
  </div>

<?php include 'includes/header.php'; ?>

<section class="welcome">

 <div class="welcome-section">
        <div class="welcome-content">
            <h1>Ideal Institute of Excellence</h1>
            <h2>Boost Your Potential with Us!</h2>
            <p>
                Achieve excellence with tailored coaching and comprehensive resources designed to help you succeed in every step of your journey.
            </p>
            <a href="register.php" class="btn">REGISTER NOW</a>
        </div>
    </div>
</section>

  <section class="courses-section">
    <p>Choose the right course to achieve your academic and career goals.</p>
    <div class="courses-container">
      <div class="course-card">
        <img src="image/course (3).jpeg" alt="NEET Preparation">
        <h3>NEET Preparation Course</h3>
        <p>Crack NEET with expert guidance, detailed study materials, and mock tests for Physics, Chemistry, and Biology.</p>
        <button 
       onclick="window.open('https://neet.nta.nic.in/', '_blank');" 
       style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
       Learn More
        </button>
      </div>
      <div class="course-card">
        <img src="image/course (1).jpeg" alt="JEE Preparation">
        <h3>JEE Preparation Course</h3>
        <p>Excel in JEE with in-depth concepts, problem-solving techniques, and mock tests for Physics, Chemistry, and Math.</p>
        <button 
       onclick="window.open('https://jeemain.nta.nic.in/', '_blank');" 
       style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
       Learn More
        </button>
      </div>
      <div class="course-card">
        <img src="image/course.png" alt="GUJCET Preparation">
        <h3>GUJCET Preparation Course</h3>
        <p>Prepare for GUJCET with state-level focused material and practice tests for Physics, Chemistry, and Math.</p>
        <button 
       onclick="window.open('https://gujcet.gseb.org/', '_blank');" 
       style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
       Learn More
        </button>
      </div>
      <div class="course-card">
        <img src="image/course (2).jpeg" alt="GSET Preparation">
        <h3>GSET Preparation Course</h3>
        <p>Achieve success in GSET with targeted study plans, expert notes, and mock exams for your field of expertise.</p>
        <button 
       onclick="window.open('https://www.gujaratset.ac.in/', '_blank');" 
       style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
       Learn More
        </button>
      </div>
      <div class="course-card">
        <img src="image/course.jpg" alt="CMAT Preparation">
        <h3>CMAT Preparation Course</h3>
        <p>Master CMAT with strategic guidance, mock tests, and preparation for Quant, Logical Reasoning, and more.</p>
        <button 
       onclick="window.open('https://cmat.nta.nic.in/', '_blank');" 
       style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
       Learn More
        </button>
      </div>
     <div class="course-card">
        <img src="image/NDA.png" alt="CMAT Preparation">
        <h3>NDA Preparation Course</h3>
        <p>Master NDA with strategic guidance, mock tests, and preparation for Quant, Logical Reasoning, and more.</p>
        <button onclick="window.open('https://nda.nic.in/', '_blank');">Learn More</button>
      </div>
     </div>
    </div>
  </section>  
  
  <section id="about" class="content-section">
      <div class="about-text">
      <h2>About Me</h2>
      <img src="image/1.jpg" alt="Your Photo" class="about-photo">
      <p>Hello! I am Arjun Soni, a passionate individual dedicated to creating meaningful experiences and sharing knowledge. I am enthusiastic about learning new things and enjoy helping others achieve their goals. My focus is on [mention areas of interest or expertise]. Feel free to get in touch with me!</p>
      </div>
      <div>
  </section>
 
   <h1 style="text-align: center; margin: 20px 0;">Photo Gallery</h1>
  <div class="gallery">
    <img src="image/1.jpg" alt="Photo 1">
    <img src="image/2.jpg" alt="Photo 2">
    <img src="image/3.jpg" alt="Photo 3">
    <img src="image/class.jpg" alt="Photo 4">
    <img src="image/library.jpg" alt="Photo 5">
    <img src="image/office.jpg" alt="Photo 6">
    <img src="image/4.jpeg" alt="Photo 7">
    <img src="image/5.jpg" alt="Photo 8">
  </div>
  <?php include 'includes/footer.php'; ?>
</body>
</html>
