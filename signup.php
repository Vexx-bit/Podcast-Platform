<?php
// Include the database configuration file
include_once 'includes/config.php';

function getIPAddress()
{
  //whether ip is from the share internet  
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }
  //whether ip is from the proxy  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  //whether ip is from the remote address  
  else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

// Check if the form has been submitted.
if (isset($_POST['submit'])) {
  // Get the form data.
  $name = $_POST['fullname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $user_ip = getIPAddress();

  // Check if the password and confirm password match.
  if ($password !== $confirmPassword) {
    echo "<script>alert('The Passwords do not match!')</script>";
  } else {

    // Check if the user already exists in the database.
    $sql_auth = "SELECT * FROM `users` WHERE user_email= '$email'";
    $result = mysqli_query($conn, $sql_auth);

    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('This email address is already registered!')</script>";
    } else {
      // Insert the user into the database.
      $sql_insert = "INSERT INTO `users` 
      (user_fullname, user_username, user_email, password, user_ip) 
      VALUES ('$name', '$username', '$email', '$password', '$user_ip' )";

      mysqli_query($conn, $sql_insert);

      // Redirect the user to the login page. 
      echo "<script>alert('Signed Up Successfully!')</script>";
      header('Location: login.php');
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Join Us Page</title>
  <link rel="stylesheet" href="assets/css/signup.css">
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
        <li><a href="contact.php" class="nav-item">Contact</a></li>
        <li><a href="faq.php" class="nav-item">FAQs</a></li>
        <li><a href="login.php" class="nav-item">Sign in</a></li>
        <li><a href="signup.php" class="nav-item active">Join Us</a></li>
      </ul>
      <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
  </header>

  <section class="signup-section">
    <div class="signup-container">
      <h2 class="signup-header">Create Your Account</h2>
      <p class="signup-subtext">Join us and become part of the community!</p>
      <form class="signup-form" method="POST" action="">
        <div class="form-group">
          <label for="fullname">Full Name</label>
          <input type="text" id="fullname" name="fullname" placeholder="Enter your name" required />
        </div>
        <div class="form-group">
          <label for="fullname">User Name</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required />
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Create a password" required />
        </div>
        <div class="form-group">
          <label for="password">Confirm Password</label>
          <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required />
        </div>
        <button type="submit" class="signup-btn" name="submit">Sign Up</button>
      </form>
      <p class="signup-footer">Already have an account? <a href="login.php">Log in</a></p>
    </div>
  </section>

  <!-- Finally the Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-links">
        <a href="episodes.php">Episodes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="faq.php">FAQs</a>
        <a href="#privacy">Privacy Policy</a>
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
</body>

</html>