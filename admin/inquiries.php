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

$sqlInquiries = "SELECT * FROM contacts ";
$resultInquiries = mysqli_query($conn, $sqlInquiries);

function displayInquiryStatus($cont_status)
{
    if ($cont_status == 'Pending') {
        echo "<td><span class='badge enquiry-status-pending'>Pending</span></td>";
    } elseif ($cont_status == 'Replied') {
        echo "<td><span class='badge enquiry-status-replied'>Replied</span></td>";
    } else {
        echo "<td><span class='badge enquiry-status-not-replied'>Unknown</span></td>"; // Optional for unknown statuses
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Inquiries</title>
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
            <li><a href="inquiries.php" class="active"><i class='bx bx-envelope'></i> Inquiries</a></li>
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
            <h1>Inquiries</h1>
        </header>

        <div class="container-fluid">
            <!-- Enquiries Table -->
            <div class="section enquiry-table-section">
                <h2>Inquiry List</h2>
                <div class="table-responsive">
                    <table class="table enquiry-table table-striped-columns table-hover w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Initialize a counter
                            $counter = 1; // Start counting from 1

                            while ($rowInquiry = mysqli_fetch_assoc($resultInquiries)) {
                                $cont_name = $rowInquiry['cont_name'];
                                $cont_id = $rowInquiry['cont_id'];
                                echo "<tr>";
                                // Echo the counter value in the first <td>
                                echo "<td>" . $counter . "</td>";
                                echo "<td>" . $rowInquiry['cont_name'] . "</td>";
                                echo "<td>" . $rowInquiry['cont_email'] . "</td>";
                                echo "<td>" . $rowInquiry['cont_message'] . "</td>";
                                // Call the function to display the status
                                displayInquiryStatus($rowInquiry['cont_status']);
                            ?>
                                <td>
                                    <a href='view_inquiries.php?cont_id=<?php echo $cont_id; ?>' class=''>View </a>|
                                    <a href=" javascript:void(0)" class="" onclick="confirmDeletion(<?php echo $rowInquiry['cont_id']; ?>)"> Delete</a>
                                </td>
                                </tr>

                            <?php
                                // Increment the counter for the next row
                                $counter++;
                            }
                            ?>
                            <!-- <tr>
                                <td>2</td>
                                <td>Bob Lee</td>
                                <td>bob.lee@example.com</td>
                                <td>Great episode, really enjoyed it!</td>
                                <td><span class="badge enquiry-status-replied">Replied</span></td>
                                <td>
                                    <a href="view_inquiries.php?cont_id=' . $rowInquiry['cont_id'] . '" class="btn btn-sm btn-primary enquiry-view-button">View</a>
                                    <a class="btn btn-sm btn-danger enquiry-delete-button">Delete</a>
                                </td>
                            </tr> -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDeletion(inquiryId) {
            let userResponse = confirm("Are you sure you want to delete this inquiry?");
            if (userResponse) {
                // If the user presses "Yes" (OK), redirect to delete_inquiry.php with the inquiry ID
                window.location.href = 'delete_inquiry.php?delete_inquiry=' + inquiryId;
            } else {
                // User pressed "No", do nothing
                console.log("Deletion canceled.");
            }
        }
    </script>

</body>

</html>