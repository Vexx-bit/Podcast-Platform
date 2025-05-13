<?php
session_start();
include 'includes/config.php';

// Check if the user is logged in
if (isset($_SESSION['user_email']) && isset($_POST['comment']) && isset($_POST['episode_id'])) {
    $userEmail = $_SESSION['user_email'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $episode_id = $_POST['episode_id'];

    // Retrieve user_id from users table based on user_email
    $sql_user = "SELECT user_id FROM users WHERE user_email = '$userEmail'";
    $result_user = mysqli_query($conn, $sql_user);

    if (mysqli_num_rows($result_user) === 1) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['user_id'];

        // Insert the comment into the comments table
        $sql_comment = "INSERT INTO comments (ep_id, user_id, comment) VALUES ('$episode_id', '$user_id', '$comment')";
        mysqli_query($conn, $sql_comment);
    }
}

// Redirect back to episodes page
header('Location: episodes.php');
exit();
