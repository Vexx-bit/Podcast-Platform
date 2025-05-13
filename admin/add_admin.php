<?php
session_start();
require_once '../includes/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location:sign_in.php");
    exit();
}

$errorMessage = "";
$successMessage = "";

// Check if the form is submitted
if (isset($_POST['add'])) {
    // Retrieve form data
    $fullName = $_POST['admin_name'];
    $email = $_POST['admin_email'];
    $password = $_POST['admin_password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Basic validation
    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errorMessage = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match.";
    } else {
        // Check if admin with the same email exists
        $sqlCheckAdmin = "SELECT * FROM admins WHERE admin_email = '$email'";
        $resultCheckAdmin = mysqli_query($conn, $sqlCheckAdmin);

        if (mysqli_num_rows($resultCheckAdmin) > 0) {
            $errorMessage = "An admin with the same email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert admin data into the database
            $sql = "INSERT INTO `admins` (admin_names, admin_email, admin_password) VALUES ('$fullName', '$email', '$hashedPassword')";
            if (mysqli_query($conn, $sql)) {
                $successMessage = "Admin registered successfully!";
                header("Location: add_admin.php");
                exit();
            } else {
                $errorMessage = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Add Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Raleway:wght@400&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class='bx bx-home'></i> Dashboard</a></li>
            <li><a href="add_episodes.php"><i class='bx bx-microphone'></i> Add Episodes</a></li>
            <li><a href="manage_users.php"><i class='bx bx-user'></i> Manage Users</a></li>
            <li><a href="inquiries.php"><i class='bx bx-envelope'></i> Inquiries</a></li>
            <li><a href="add_admin.php" class="active"><i class='bx bx-user-plus'></i> Add Admin</a></li>
            <li><a href="settings.php"><i class='bx bx-cog'></i> Settings</a></li>
            <li><a href="logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
        <div class="sidebar-footer">
            <p>© 2024 My Girls Podcast.</p>
        </div>
    </aside>

    <!-- Main Content -->
    <section class="main-content">
        <header class="main-header">
            <h1>Add New Admin</h1>
        </header>

        <div class="container">
            <!-- Notification about Admin Capabilities -->
            <div class="alert alert-info" role="alert">
                <h4>Admin Capabilities:</h4>
                <p>As an admin, you have the ability to manage episodes, users, inquiries, and settings within the dashboard. You can also add or remove other admins, moderate content, and ensure the smooth operation of the podcast platform.</p>
            </div>

            <!-- Add Admin Form -->
            <div class="add-admin-form-section">
                <h2>Admin Details</h2>
                <form action="" method="POST">
                    <div class="form-group mb-3">
                        <label for="admin-name">Admin Full Names</label>
                        <input type="text" class="form-control" id="admin-name" name="admin_name" placeholder="Enter admin name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="admin-email">Admin Email</label>
                        <input type="email" class="form-control" id="admin-email" name="admin_email" placeholder="Enter admin email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="admin-password">Admin Password</label>
                        <input type="password" class="form-control" id="admin-password" name="admin_password" placeholder="Enter admin password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="admin-password">Admin Password Confirmation</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm admin password" required>
                    </div>
                    <!-- Displaying error message -->
                    <?php if ($errorMessage !== ""): ?>
                        <div class="form-group alert alert-danger mt-3" role="alert">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($successMessage !== ""): ?>
                        <div class="form-group alert alert-success mt-3" role="alert">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" name="add" class="btn btn-primary">Add Admin</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>