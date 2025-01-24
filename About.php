<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'includes/head.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      color: #333;
    }
    h2 {
      font-size: 2rem;
      color: #4CAF50;
      margin-bottom: 20px;
    }
    p {
      font-size: 1rem;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    /* Container */
    .container {
      width: 90%;
      margin: 0 auto;
      padding: 40px 0;
    }

    /* Vision Section */
    .vision-section {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 40px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    .vision-section ul {
      list-style-type: none;
      padding-left: 0;
    }
    .vision-section ul li {
      font-size: 1.1rem;
      margin-bottom: 10px;
    }
    .vision-section ul li strong {
      color: #4CAF50;
    }

    /* Teachers Section */
    .teachers-section {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 40px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    .teachers {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }
    .teacher {
      background-color: #f9f9f9;
      border-radius: 8px;
      width: 30%;
      text-align: center;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }
    .teacher img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
    }
    .teacher h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: #333;
    }
    .teacher p {
      font-size: 1rem;
      color: #555;
    }
    .teacher:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>
  
  <script>
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      navLinks.classList.toggle('active');
    }
  </script>

  <div class="container">
    <div class="vision-section">
      <h2>About Us</h2>
      <p>At <strong>Ideal Institute</strong>, located in Mandvi, Bhuj, we are committed to providing exceptional coaching for some of the most competitive exams in India. Whether you're aiming to enter top engineering colleges, medical universities, or secure a government job, we are here to help you achieve your goals.</p>
      <p>Our experienced faculty and well-structured curriculum are designed to provide comprehensive preparation for the following exams:</p>
      
      <ul>
        <li><strong>NEET:</strong> National Eligibility cum Entrance Test for medical fields.</li>
        <li><strong>JEE:</strong> Joint Entrance Examination for top engineering colleges like IITs and NITs.</li>
        <li><strong>GUJCET:</strong> Gujarat Common Entrance Test for admissions in Gujarat.</li>
        <li><strong>GSET:</strong> Gujarat State Eligibility Test for Assistant Professor position.</li>
        <li><strong>CMAT:</strong> Common Management Admission Test for MBA courses.</li>
        <li><strong>AIIMS:</strong> Coaching for the prestigious AIIMS medical exam.</li>
        <li><strong>NDA:</strong> Coaching for the National Defence Academy exams.</li>
      </ul>

      <h2>Our Vision</h2>
      <p>To be a leading educational institute that produces successful candidates for competitive exams, shaping the future of India’s brightest minds and preparing them for careers in medicine, engineering, management, and defense services.</p>
    </div>

    <div class="teachers-section">
      <h2>Meet Our Teachers</h2>
      <div class="teachers">
        <div class="teacher">
          <img src="image/1.jpg" alt="Teacher 1">
          <h3>Dr. A. Kumar</h3>
          <p>Physics Expert | 10+ Years of Teaching Experience</p>
        </div>
        <div class="teacher">
          <img src="image/2.jpg" alt="Teacher 2">
          <h3>Ms. S. Patel</h3>
          <p>Chemistry Expert | Specializing in NEET & JEE</p>
        </div>
        <div class="teacher">
          <img src="image/3.jpg" alt="Teacher 3">
          <h3>Mr. R. Shah</h3>
          <p>Mathematics Expert | JEE & GSET Specialist</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Section -->
  <?php include 'includes/footer.php'; ?>
</body>
</html>
