<?php
session_start();
include('../includes/config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: sign_in.php");
    exit();
}


if (isset($_POST['submit'])) {
    // Collect form data
    $episode_title = $_POST['episode_title'];
    $episode_desc = $_POST['episode_desc'];

    // Accessing audio and thumbnail files
    $episode_audio = $_FILES['episode_audio']['name'];
    $episode_thumbnail = $_FILES['episode_thumbnail']['name'];

    // Accessing temporary file names
    $temp_audio = $_FILES['episode_audio']['tmp_name'];
    $temp_thumbnail = $_FILES['episode_thumbnail']['tmp_name'];

    // Checking for empty fields
    if ($episode_title == '' || $episode_desc == '' || $episode_audio == '' || $episode_thumbnail == '') {
        echo "<script>alert('Please fill all the fields')</script>";
    } else {
        // Escape special characters
        $episode_title = mysqli_real_escape_string($conn, $episode_title);
        $episode_desc = mysqli_real_escape_string($conn, $episode_desc);
        $episode_audio = mysqli_real_escape_string($conn, $episode_audio);
        $episode_thumbnail = mysqli_real_escape_string($conn, $episode_thumbnail);

        // Move uploaded files to their respective directories
        move_uploaded_file($temp_audio, "uploads/audio/$episode_audio");
        move_uploaded_file($temp_thumbnail, "uploads/thumbnails/$episode_thumbnail");

        // Insert query
        $insert_episode = "INSERT INTO episodes (ep_title, ep_desc, ep_audio, ep_thumbnail) 
                           VALUES ('$episode_title', '$episode_desc', '$episode_audio', '$episode_thumbnail')";

        $result_query = mysqli_query($conn, $insert_episode);

        if ($result_query) {
            echo "<script>alert('New episode added successfully!')</script>";
        } else {
            echo "Error: " . $insert_episode . "<br>" . mysqli_error($conn);
        }
    }
}

// Close the connection at the end of the script
mysqli_close($conn);
?>


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Add Episodes</title>
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
            <li><a href="add_episodes.php" class="active"><i class='bx bx-microphone'></i> Add Episodes</a></li>
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
            <h1>Add New Episode</h1>
        </header>

        <div class="container episodes-form-section">
            <!-- Add Episode Form -->
            <h2>Episode Details</h2>
            <form class="form" action="add_episodes.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="episode-title">Episode Title</label>
                    <input type="text" id="episode-title" name="episode_title" class="form-control" placeholder="Enter episode title" required>
                </div>
                <div class="form-group">
                    <label for="episode-description">Episode Description(Brief as Possible)</label>
                    <textarea id="episode-description" name="episode_desc" class="form-control" rows="5" placeholder="Enter episode description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="episode-file">Upload Audio(mp3)</label>
                    <input type="file" id="episode-file" name="episode_audio" class="form-control" accept="audio/*" required>
                </div>
                <div class="form-group">
                    <label for="episode-thumbnail">Upload Thumbnail (Wide Image Recommended: Minimum 1200x675 pixels)</label>
                    <input type="file" id="episode-thumbnail" name="episode_thumbnail" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Add Episode</button>
            </form>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>