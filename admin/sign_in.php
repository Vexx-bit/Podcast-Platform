<?php
session_start();
require_once '../includes/config.php';

// Initialize variables for error messages
$errorMessage = "";

// Check if the form is submitted
if (isset($_POST['login'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve admin data from the database
    $sql = "SELECT * FROM admins WHERE admin_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['admin_password'])) {
            // Successful login
            $_SESSION['admin_email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Incorrect password.";
        }
    } else {
        $errorMessage = "Admin not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sign In</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Raleway:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        :root {
            /* Primary Colors */
            --color-blush-pink: #f9bbbc;
            --color-warm-coral: #ef3972;
            --color-soft-peach: #ddecfc;

            /* Accent Colors */
            --color-golden-yellow: #ffe089;
            --color-lavender: #e6cdea;

            /* Dark Mode Colors */
            --color-dark-plum: #4799f1;
            --color-white: #FFFFFF;
            --color-muted-pink: ##d6a2b2;
            --color-cream-white: #fff7e6;
            --color-soft-gray: #c2c2c2;

            /* Font Families */
            --font-header: 'Poppins', sans-serif;
            --font-body: 'Raleway', sans-serif;

            /* Common Text Colors */
            --color-text-dark: #2d2d2d;
            --color-text-light: #fff4e1;

            /* Shadow */
            --box-shadow-light: 0 4px 6px rgba(0, 0, 0, 0.1);

            /* Border Radius */
            --border-radius: 8px;
        }

            /* Global Heading Styles */
            h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-header);
            color: var(--color-warm-coral);
            margin: 1rem 0;
            }
  

        body {
            background-color: var(--color-soft-peach);
            font-family: var(--font-body);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .sign-in-container {
            background-color: var(--color-cream-white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-light);
            width: 400px;
        }

        h2 {
            font-family: var(--font-header);
            color: var(--color-text-dark);
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: var(--color-text-dark);
        }

        .btn-signin {
            background-color: var(--color-warm-coral);
            color: var(--color-text-light);
            border: none;
        }

        .btn-signin:hover {
            background-color: var(--color-golden-yellow);
        }

        .footer-text {
            text-align: center;
            margin-top: 1rem;
            color: var(--color-text-dark);
        }
    </style>
</head>

<body>

    <div class="sign-in-container">
        <h2>Admin Panel</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <!-- Displaying error message -->
            <?php if ($errorMessage !== ""): ?>
                <div class="form-group alert alert-danger mt-3 mb-2" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
            <button type="submit" name="login" class="btn btn-signin btn-block mt-2">Sign In</button>
        </form>
        <div class="footer-text">
            <p>© 2024 My Girls Podcast.</p>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>