<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];

    // Fetch user_id based on user_email
    $user_query = "SELECT user_id,user_ip FROM users WHERE user_email = '$user_email'";
    $user_result = mysqli_query($conn, $user_query);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['user_id'];
        $user_ip = $user_row['user_ip'];
        $ep_id = $_POST['episode_id'];

        // Check if the episode is already in favorites
        $check_query = "SELECT * FROM favorites WHERE ep_id = '$ep_id' AND user_id = '$user_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If episode is already in favorites, redirect with a message
            echo "<script>alert('This episode is already in your favorites!'); window.location.href='episodes.php';</script>";
            exit();
        }

        // Get episode details
        $episode_query = "SELECT ep_title, ep_desc, ep_audio, ep_thumbnail FROM episodes WHERE ep_id = '$ep_id'";
        $episode_result = mysqli_query($conn, $episode_query);

        if ($episode_result && mysqli_num_rows($episode_result) > 0) {
            $episode = mysqli_fetch_assoc($episode_result);

            // Prepare to insert into favorites table
            $fav_title = $episode['ep_title'];
            $fav_desc = $episode['ep_desc'];
            $fav_audio = $episode['ep_audio'];
            $fav_thumbnail = $episode['ep_thumbnail'];

            // Insert into favorites table
            $insert_query = "INSERT INTO favorites (fav_title, fav_desc, fav_audio, fav_thumbnail, ep_id, user_id, user_ip) 
                             VALUES ('$fav_title', '$fav_desc', '$fav_audio', '$fav_thumbnail', '$ep_id', '$user_id', '$user_ip')";

            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Episode added to favorites!'); window.location.href='episodes.php';</script>";
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Episode not found.";
        }
    } else {
        echo "User not found.";
    }
} else {
    header('Location: episodes.php');
    exit();
}
