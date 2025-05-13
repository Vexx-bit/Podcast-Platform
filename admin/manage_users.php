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

$adminName = "";
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $adminName = $row['admin_names'];
}

$sqlUsers = "SELECT * FROM users ";
$resultUsers = mysqli_query($conn, $sqlUsers);

// Delete a student
if (isset($_GET['deleteStudent'])) {
    $studentID = intval($_GET['deleteStudent']);
    $deleteStudentQuery = "DELETE FROM users WHERE user_id = $studentID";
    if (mysqli_query($conn, $deleteStudentQuery)) {
        echo "<script>window.location.href='manage_users.php';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Manage Users</title>
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
            <li><a href="manage_users.php" class="active"><i class='bx bx-user'></i> Manage Users</a></li>
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
            <h1>Manage Users</h1>
        </header>

        <div class="container-fluid">
            <!-- Users Table -->
            <div class="section user-table-section">
                <h2>User List</h2>
                <div class="table-responsive">
                    <table class="table user-table table-striped table-hover w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ip</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Initialize a counter
                            $counter = 1; // Start counting from 1

                            while ($rowUsers = mysqli_fetch_assoc($resultUsers)) {
                                echo "<tr>";
                                // Echo the counter value in the first <td>
                                echo "<td>" . $counter . "</td>";
                                echo "<td>" . $rowUsers['user_fullname'] . "</td>";
                                echo "<td>" . $rowUsers['user_email'] . "</td>";
                                echo "<td>" . $rowUsers['user_ip'] . "</td>";
                                echo "<td class='text-center m-auto'><span class='badge user-status-active'>Active</span></td>
                                        <td class='text-center m-auto'>
                                            <a href='manage_users.php?deleteStudent=" . $rowUsers['user_id'] . "' class='btn user-delete-button'>Delete</a>
                                        </td>";
                                echo "</tr>";
                                // Increment the counter for the next row
                                $counter++;
                            }
                            ?>
                            <!-- <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john.doe@example.com</td>
                                <td>Admin</td>
                                <td><span class="badge user-status-active">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary user-edit-button">Edit</button>
                                    <button class="btn btn-sm btn-danger user-delete-button">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane.smith@example.com</td>
                                <td>Moderator</td>
                                <td><span class="badge user-status-pending">Pending</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary user-edit-button">Edit</button>
                                    <button class="btn btn-sm btn-danger user-delete-button">Delete</button>
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td>3</td>
                                <td>Mark Wilson</td>
                                <td>mark.wilson@example.com</td>
                                <td>User</td>
                                <td><span class="badge user-status-inactive">Inactive</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary user-edit-button">Edit</button>
                                    <button class="btn btn-sm btn-danger user-delete-button">Delete</button>
                                </td>
                            </tr> -->
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>