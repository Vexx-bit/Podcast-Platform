<?php
session_start();
include 'includes/config.php';
include 'functions/functions.php';

// Initialize user variables
$userEmail = null;
$userName = null;

// Check if user is logged in
if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];

    // Retrieve user data from the database
    $sql = "SELECT * FROM users WHERE user_email = '$userEmail'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userName = $row['user_username'];
    }
}

// Handle the like submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like'])) {
    $episode_id = $_POST['episode_id'];
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if this IP already liked this episode
    $check_like_query = "SELECT * FROM likes WHERE ep_id = '$episode_id' AND user_ip = '$user_ip'";
    $check_result = mysqli_query($conn, $check_like_query);

    if (mysqli_num_rows($check_result) == 0) {
        // If not liked yet, insert a new record with like_count set to 1
        $insert_like_query = "INSERT INTO likes (ep_id, user_ip, like_count) VALUES ('$episode_id', '$user_ip', 1)";
        mysqli_query($conn, $insert_like_query);
    } else {
        // Increment the like count
        $update_like_query = "UPDATE likes SET like_count = like_count + 1 WHERE ep_id = '$episode_id' AND user_ip = '$user_ip'";
        mysqli_query($conn, $update_like_query);
    }
}

// Initialize search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch all episodes
$select_query = "SELECT * FROM `episodes` ";
$result_query = mysqli_query($conn, $select_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Episodes Results</title>
    <link rel="stylesheet" href="assets/css/episodes.css">
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
                <?php if (isset($_SESSION['user_email'])): ?>
                    <li><a href="logout.php" class="nav-item">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="nav-item">Sign in</a></li>
                    <li><a href="signup.php" class="nav-item">Join Us</a></li>
                <?php endif; ?>
            </ul>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <div class="container">
        <!-- Search Bar -->
        <section class="search-section">
            <h2>Browse Episodes</h2>
            <div class="search-bar">
                <form action="search_episode.php" method="GET">
                    <input type="text" id="search-input" name="search" placeholder="Search episodes..." required>
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="filters-section">
            <h3>Filter Episodes</h3>
            <div class="filters">
                <a href="episodes.php" class="filter-btn" style="text-decoration: none;">All</a>
                <a href="latest_episodes.php" class="filter-btn" style="text-decoration: none;">Latest</a>
                <a href="popular_episodes.php" class="filter-btn active" style="text-decoration: none;">Popular</a>
                <a href="favorite_episodes.php" class="filter-btn" style="text-decoration: none;">Favorites</a>
            </div>
        </section>

        <!-- Episodes Section -->
        <?php
        display_popular_episodes(); // Call the function to display episodes
        ?>
    </div>

    <!-- Finally the Footer -->
    <footer class="footer">
        <div class="footer-container">
            <p class="footer-copy">© 2024 My Girls Podcast. All Rights Reserved.</p>
        </div>
    </footer>

    <script type="text/javascript" src="assets/js/script.js"></script>
    <script>
        // Save scroll position in localStorage
        window.addEventListener('beforeunload', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Restore scroll position
        window.addEventListener('load', function() {
            if (localStorage.getItem('scrollPosition') !== null) {
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
            }
        });

        //displaying comment sections
        document.addEventListener("DOMContentLoaded", function() {
            // Get all the message icons
            const messageIcons = document.querySelectorAll('.bxs-message-dots');

            messageIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    // Find the episode card that contains this icon
                    const episodeCard = this.closest('.episode-card');

                    // Get the corresponding comment section and display comments
                    const commentSection = episodeCard.querySelector('.comment-section');
                    const displayComments = episodeCard.querySelector('.display-comments');

                    // Toggle the display property
                    if (commentSection.style.display === 'none') {
                        commentSection.style.display = 'block';
                    } else {
                        commentSection.style.display = 'none';
                    }

                    if (displayComments.style.display === 'none') {
                        displayComments.style.display = 'block';
                    } else {
                        displayComments.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>