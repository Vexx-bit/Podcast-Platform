<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Log out</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Raleway:wght@400&display=swap" rel="stylesheet">
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
            <!-- <li><a href="#"><i class='bx bx-message-square-detail'></i> Feedback</a></li> -->
            <li><a href="inquiries.php"><i class='bx bx-envelope'></i> Inquiries</a></li>
            <li><a href="add_admin.php"><i class='bx bx-user-plus'></i> Add Admin</a></li>
            <li><a href="settings.php"><i class='bx bx-cog'></i> Settings</a></li>
            <li><a href="logout.php" class="active"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
        <div class="sidebar-footer">
            <p>© 2024 My Girls Podcast.</p>
        </div>
    </aside>

    <!-- Main Content -->
    <section class="main-content">
        <header class="main-header">
            <h1>Logging Out?</h1>
        </header>

        <div class="container logout-section">
            <h2>Logout</h2>
            <p>Are you sure you want to log out?</p>
            <div class="logout-actions">
                <a href="logout_now.php" class="btn confirm-logout">Yes, Logout</a>
                <a href="logout.php" class="btn cancel-logout">Cancel</a>
            </div>
        </div>

    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>