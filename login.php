<?php
session_start(); // Start the session

// Include the database configuration file
include_once 'includes/config.php';

if (isset($_POST['sign_in'])) {
    // Get the form data.
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $login = "SELECT * FROM `users` WHERE `user_email` = '$email'";
    $result_login = mysqli_query($conn, $login);

    if (mysqli_num_rows($result_login) > 0) {
        // The user exists, fetch user details
        $user = mysqli_fetch_assoc($result_login);

        // Check if the provided password matches the stored password
        // Note: Ideally, you should hash passwords for security
        if ($user['password'] === $password) {
            // Set session variable for user email
            $_SESSION['user_email'] = $user['user_email'];

            echo "<script>alert('Logged in successfully')</script>";
            header('Location: episodes.php');
            exit(); // Always use exit() after header redirection
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password.')</script>";
        }
    } else {
        // The user does not exist
        echo "<script>alert('The user does not exist.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css">
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
                <li><a href="login.php" class="nav-item active">Sign in</a></li>
                <li><a href="signup.php" class="nav-item">Join Us</a></li>
            </ul>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <section class="login-section">
        <div class="login-container">
            <h2 class="login-header">Welcome Back!</h2>
            <p class="login-subtext">Log in to your account</p>
            <form class="login-form" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required />
                </div>
                <button type="submit" name="sign_in" class="login-btn">Log In</button>
            </form>
            <p class="login-footer">Don't have an account? <a href="signup.php">Sign up</a></p>
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