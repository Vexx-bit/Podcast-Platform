<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $enqName = mysqli_real_escape_string($conn, $_POST['name']);
  $enqEmail = mysqli_real_escape_string($conn, $_POST['email']);
  $enqMessage = mysqli_real_escape_string($conn, $_POST['message']);
  $enqStatus = "Pending";

  // Insert enquiry data into the database
  $sqlInsertEnquiry = "INSERT INTO contacts (cont_name, cont_email, cont_message, cont_status) VALUES ('$enqName', '$enqEmail', '$enqMessage', '$enqStatus')";

  if (mysqli_query($conn, $sqlInsertEnquiry)) {
    // Redirect to homepage or show success message
    echo "<script>alert('Sent Successfully')</script>";
    echo "<script>window.open('contact.php','_self')</script>";
    exit();
  } else {
    // Handle error if the insertion fails
    $errorMessage = "Error: " . mysqli_error($conn);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us Page</title>
  <link rel="stylesheet" href="assets/css/contact.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

  <!-- Navigation Bar -->
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="#">My Girls Talk</a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php" class="nav-item">Home</a></li>
        <li><a href="episodes.php" class="nav-item">Episodes</a></li>
        <li><a href="about.php" class="nav-item">About</a></li>
        <li><a href="contact.php" class="nav-item active">Contact</a></li>
        <li><a href="faq.php" class="nav-item">FAQs</a></li>
        <li><a href="login.php" class="nav-item">Sign in</a></li>
        <li><a href="signup.php" class="nav-item">Join Us</a></li>
      </ul>
      <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
  </header>

  <div class="contact-us-container">
    <!-- Hero Section -->
    <section class="hero-contact">
      <h1>We’d Love to Hear from You</h1>
      <p>Have questions, feedback, or just want to connect? Reach out to us, and we’ll get back to you as soon as possible.</p>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info">
      <div class="contact-method">
        <i class='bx bx-envelope'></i>
        <h3>Email Us</h3>
        <p><a href="mailto:info@mygirlstalk.com">info@mygirlstalk.com</a></p>
      </div>

      <div class="contact-method">
        <i class='bx bx-phone'></i>
        <h3>Call Us</h3>
        <p><a href="tel:+1234567890">+123 456 7890</a></p>
      </div>

      <div class="contact-method">
        <i class='bx bxl-instagram'></i>
        <h3>Follow Us</h3>
        <p><a href="https://instagram.com/mygirlstalk">@mygirlstalk</a></p>
      </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form">
      <h2>Send Us a Message</h2>
      <form method="POST">
        <div class="form-group">
          <label for="name">Your Name</label>
          <input type="text" id="name" name="name" required placeholder="Enter your name">
        </div>
        <div class="form-group">
          <label for="email">Your Email</label>
          <input type="email" id="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="form-group">
          <label for="message">Your Message</label>
          <textarea id="message" name="message" rows="5" required placeholder="Enter your message"></textarea>
        </div>
        <button type="submit" name="submit" class="submit-button">Send Message</button>
      </form>
    </section>

    <!-- FAQ Section (Optional) -->
    <section class="faq">
      <h2>Need Help?</h2>
      <p>Check out our <a href="faq.php">FAQ</a> for answers to common questions.</p>
    </section>
  </div>


  <!-- Finally the Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-links">
        <a href="episodes.php">Episodes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="faq.php">FAQs</a>

      </div>
      <div class="footer-socials">
        <a href="https://twitter.com/" target="_blank">Twitter</a>
        <a href="https://facebook.com/" target="_blank">Facebook</a>
        <a href="https://instagram.com/" target="_blank">Instagram</a>
        <a href="https://linkedin.com/" target="_blank">LinkedIn</a>
      </div>
      <p class="footer-copy">© 2024 My Girls Podcast. All Rights Reserved.</p>
    </div>
  </footer>
  <script type="text/javascript" src="assets/js/script.js"></script>
  <script>
    // Save scroll position in localStorage
    window.addEventListener('beforeunload', function() {
      localStorage.setItem('scrollPosition', window.scrollY);
    });

    // Restore scroll position
    window.addEventListener('load', function() {
      if (localStorage.getItem('scrollPosition') !== null) {
        window.scrollTo(0, localStorage.getItem('scrollPosition'));
      }
    });
  </script>
</body>

</html>