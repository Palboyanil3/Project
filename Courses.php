<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'includes/head.php'; ?>
<body>
  <?php include 'includes/header.php'; ?>
  <script>
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      navLinks.classList.toggle('active');
    }
  </script>
  <section class="courses-section">
    <h2>Our Courses</h2>
    <p>Choose the right course to achieve your academic and career goals.</p>
    <div class="courses-container" id="coursesContainer">
      <div class="course-card">
        <img src="image/course (3).jpeg" alt="NEET Preparation">
        <h3>NEET Preparation Course</h3>
        <p>Crack NEET with expert guidance, detailed study materials, and mock tests for Physics, Chemistry, and Biology.</p>
        <button onclick="window.open('https://neet.nta.nic.in/', '_blank');">Learn More</button>
      </div>
      <div class="course-card">
        <img src="image/course (1).jpeg" alt="JEE Preparation">
        <h3>JEE Preparation Course</h3>
        <p>Excel in JEE with in-depth concepts, problem-solving techniques, and mock tests for Physics, Chemistry, and Math.</p>
        <button onclick="window.open('https://jeemain.nta.nic.in/', '_blank');">Learn More</button>
      </div>
      <div class="course-card">
        <img src="image/course.png" alt="GUJCET Preparation">
        <h3>GUJCET Preparation Course</h3>
        <p>Prepare for GUJCET with state-level focused material and practice tests for Physics, Chemistry, and Math.</p>
        <button onclick="window.open('https://gujcet.gseb.org/', '_blank');">Learn More</button>
      </div>
      <div class="course-card">
        <img src="image/course (2).jpeg" alt="GSET Preparation">
        <h3>GSET Preparation Course</h3>
        <p>Achieve success in GSET with targeted study plans, expert notes, and mock exams for your field of expertise.</p>
        <button onclick="window.open('https://www.gujaratset.ac.in/', '_blank');">Learn More</button>
      </div>
      <div class="course-card">
        <img src="image/course.jpg" alt="CMAT Preparation">
        <h3>CMAT Preparation Course</h3>
        <p>Master CMAT with strategic guidance, mock tests, and preparation for Quant, Logical Reasoning, and more.</p>
        <button onclick="window.open('https://cmat.nta.nic.in/', '_blank');">Learn More</button>
      </div>
      <div class="course-card">
        <img src="image/AIIMS.png" alt="CMAT Preparation">
        <h3>AIIMS Preparation Course</h3>
        <p>AIIMS coaching for preparing for the entrance exam.</p>
        <button onclick="window.open('https://www.aiimsexams.ac.in/', '_blank');">Learn More</button>
      </div>
      <div class="course-card">
        <img src="image/NDA.png" alt="CMAT Preparation">
        <h3>NDA Preparation Course</h3>
        <p>Master NDA with strategic guidance, mock tests, and preparation for Quant, Logical Reasoning, and more.</p>
        <button onclick="window.open('https://nda.nic.in/', '_blank');">Learn More</button>
      </div>
    </div>
  </section>
  <?php include 'includes/footer.php'; ?>
<script>
  const container = document.getElementById('coursesContainer');

  // Autoplay scroll function
  function autoScroll() {
    const scrollAmount = 300;
    const maxScroll = container.scrollWidth - container.clientWidth;

    if (container.scrollLeft + scrollAmount >= maxScroll) {
      container.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
  }

  setInterval(autoScroll, 3000);
</script>

</body>
</html>
