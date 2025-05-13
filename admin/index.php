<?php
session_start();
require_once '../includes/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: sign_in.php");
    exit();
}

$adminEmail = $_SESSION['admin_email'];

// Retrieve admin data from the database
$sql = "SELECT * FROM admins WHERE admin_email = '$adminEmail'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $adminName = $row['admin_names'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | My Girls Podcast</title>
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
            <li><a href="index.php" class="active"><i class='bx bx-home'></i> Dashboard</a></li>
            <li><a href="add_episodes.php"><i class='bx bx-microphone'></i> Add Episodes</a></li>
            <li><a href="manage_episodes.php"><i class='bx bx-microphone'></i> Manage Episodes</a></li>
            <li><a href="manage_users.php"><i class='bx bx-user'></i> Manage Users</a></li>
            <!-- <li><a href="#"><i class='bx bx-message-square-detail'></i> Feedback</a></li> -->
            <li><a href="inquiries.php"><i class='bx bx-envelope'></i> Inquiries</a></li>
            <li><a href="add_admin.php"><i class='bx bx-user-plus'></i> Add Admin</a></li>
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
            <h1>Welcome, <?php echo "$adminName"; ?></h1>
        </header>

        <div class="container">
            <!-- Cards for Summary Stats -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <i class='bx bx-microphone'></i>
                        <h3>
                            <?php
                            $sql = "SELECT * FROM episodes";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?> episodes</h3>
                        <p>Episodes</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <i class='bx bx-user'></i>
                        <h3><?php
                            $sql = "SELECT * FROM users";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?> users</h3>
                        <p>Users</p>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <i class='bx bx-message-square-detail'></i>
                        <h3>Feedback</h3>
                        <p>30 feedbacks</p>
                    </div>
                </div> -->
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <i class='bx bx-envelope'></i>
                        <h3>
                            <?php
                            $sql = "SELECT * FROM contacts";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?>
                            inquiries</h3>
                        <p>Inquiries</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>