<?php

function get_all_episodes($result_query)
{
    global $conn; // Declare $conn as global to access the database connection

    echo '<section class="episodes-section">
            <h3>All Episodes</h3>
            <div class="episodes-grid">';

    while ($row = mysqli_fetch_assoc($result_query)) {
        $ep_id = $row['ep_id'];
        $ep_title = $row['ep_title'];
        $ep_desc = $row['ep_desc'];
        $ep_audio = $row['ep_audio'];
        $ep_thumbnail = $row['ep_thumbnail'];

        // Fetch like count
        $like_query = "SELECT like_count FROM likes WHERE ep_id = '$ep_id'";
        $like_result = mysqli_query($conn, $like_query);
        $like_count = mysqli_num_rows($like_result) > 0 ? mysqli_fetch_assoc($like_result)['like_count'] : 0;

        // Fetch comment count
        $comment_query = "SELECT COUNT(*) as comment_count FROM comments WHERE ep_id = '$ep_id'";
        $comment_result = mysqli_query($conn, $comment_query);
        $comment_count = mysqli_num_rows($comment_result) > 0 ? mysqli_fetch_assoc($comment_result)['comment_count'] : 0;

        echo "
        <!-- Episode Card -->
        <div class='episode-card'>
            <div class='episode-thumbnail' style='border-radius: var(--border-radius);'>
                <img src='admin/uploads/thumbnails/{$ep_thumbnail}' alt='{$ep_title}' style='border-radius: var(--border-radius);'>
            </div>
            <div class='episode-info' style='padding: 20px;'>
                <h4 style='color: var(--color-warm-coral); font-family: var(--font-header);'>{$ep_title}</h4>
                <p style='color: var(--color-text-dark); font-family: var(--font-body);'>{$ep_desc}</p>
                <audio controls style='width: 100%; margin-bottom: 10px;'>
                    <source src='admin/uploads/audio/{$ep_audio}' type='audio/mpeg'>
                    Your browser does not support the audio element.
                </audio>
                <div class='episode-icons' style='display: flex; gap: 10px;'>
                    <form method='POST' action=''>
                        <input type='hidden' name='episode_id' value='{$ep_id}'>
                        <button type='submit' name='like' class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                            <i class='bx bxs-heart'></i><span class='like_no'>{$like_count}</span>
                        </button>
                    </form>
                    <button class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                        <i class='bx bxs-message-dots'></i><span class='comment_no'>{$comment_count}</span>
                    </button>";
        if (isset($_SESSION['user_email'])) {
            echo "
            <form action='add_favorite.php' method='POST'>
                <input type='hidden' name='episode_id' value='{$ep_id}'>
                <button class='icon-button' name='bookmark' type='submit' style='background: none; border: none; color: var(--color-warm-coral);'><i class='bx bxs-bookmark'></i></button>
            </form>";
        }
        echo "
                </div>
                <!-- Comment Section -->
                <div class='comment-section' id='comment-section-{$ep_id}' style='margin-top: 20px; display: none;'>
                    <h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Leave a Comment</h5>";

        if (isset($_SESSION['user_email'])) {
            echo "
            <form action='submit_comment.php' method='POST' class='comment-form'>
                <input type='hidden' name='episode_id' value='{$ep_id}'>
                <textarea name='comment' rows='3' placeholder='Your Comment' style='width: 100%; padding: 10px; border-radius: var(--border-radius); border: 1px solid var(--color-soft-gray);'></textarea>
                <button type='submit' style='background-color: var(--color-warm-coral); color: var(--color-text-light); padding: 10px 20px; border: none; border-radius: var(--border-radius); margin-top: 10px;'>Post Comment</button>
            </form>";
        } else {
            echo "<p style='color: var(--color-text-dark);'>Please <a href='login.php' style='color: var(--color-warm-coral);'>log in</a> or <a href='signup.php' style='color: var(--color-warm-coral);'>sign up</a> to leave a comment.</p>";
        }

        echo "
                </div>
                <!-- Display Comments -->
                <div class='display-comments' id='display-comments-{$ep_id}' style='margin-top: 20px; overflow: auto; height: 100px; display: none;'>";

        // Fetch comments for the current episode
        $fetch_comments_query = "SELECT * FROM comments WHERE ep_id = '$ep_id' ORDER BY created_at DESC";
        $comments_result = mysqli_query($conn, $fetch_comments_query);

        echo "<h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Comments</h5>";
        if (mysqli_num_rows($comments_result) > 0) {
            while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                $comment_text = $comment_row['comment'];
                $user_id = $comment_row['user_id'];

                // Fetch the username based on user_id
                $fetch_user_query = "SELECT user_username FROM users WHERE user_id = '$user_id'";
                $user_result = mysqli_query($conn, $fetch_user_query);
                $username = mysqli_num_rows($user_result) > 0 ? mysqli_fetch_assoc($user_result)['user_username'] : '';

                echo "
                <div class='comment' style='background-color: var(--color-cream-white); padding: 10px; border-radius: var(--border-radius); margin-bottom: 10px; max-height: 100px; position: relative;'>
                    <strong style='color: var(--color-dark-plum);'>" . htmlspecialchars($username) . ":</strong>
                    <p style='color: var(--color-text-dark);'>" . htmlspecialchars($comment_text) . "</p>
                </div>";
            }
        } else {
            echo "<p>No comments yet. Be the first to comment!</p>";
        }

        echo "
                </div>
            </div>
        </div>";
    }

    echo "
            </div>
        </section>";
}


function search_episodes($search_query)
{
    global $conn; // Declare $conn as global to access the database connection

    // Sanitize the search query to prevent SQL injection
    $search_query = mysqli_real_escape_string($conn, $search_query);

    // Search episodes by title or description
    $sql = "SELECT * FROM episodes WHERE ep_title LIKE '%$search_query%' OR ep_desc LIKE '%$search_query%'";
    $result_query = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($result_query) > 0) {
        echo '<section class="episodes-section">
                <h3>Search Results for "' . htmlspecialchars($search_query) . '"</h3>
                <div class="episodes-grid">';

        while ($row = mysqli_fetch_assoc($result_query)) {
            $ep_id = $row['ep_id'];
            $ep_title = $row['ep_title'];
            $ep_desc = $row['ep_desc'];
            $ep_audio = $row['ep_audio'];
            $ep_thumbnail = $row['ep_thumbnail'];

            // Fetch like count
            $like_query = "SELECT like_count FROM likes WHERE ep_id = '$ep_id'";
            $like_result = mysqli_query($conn, $like_query);
            $like_count = mysqli_num_rows($like_result) > 0 ? mysqli_fetch_assoc($like_result)['like_count'] : 0;

            // Fetch comment count
            $comment_query = "SELECT COUNT(*) AS comment_count FROM comments WHERE ep_id = '$ep_id'";
            $comment_result = mysqli_query($conn, $comment_query);
            $comment_count = mysqli_fetch_assoc($comment_result)['comment_count'];

            echo "
            <!-- Episode Card -->
            <div class='episode-card'>
                <div class='episode-thumbnail' style='border-radius: var(--border-radius);'>
                    <img src='admin/uploads/thumbnails/{$ep_thumbnail}' alt='{$ep_title}' style='border-radius: var(--border-radius);'>
                </div>
                <div class='episode-info' style='padding: 20px;'>
                    <h4 style='color: var(--color-warm-coral); font-family: var(--font-header);'>{$ep_title}</h4>
                    <p style='color: var(--color-text-dark); font-family: var(--font-body);'>{$ep_desc}</p>
                    <audio controls style='width: 100%; margin-bottom: 10px;'>
                        <source src='admin/uploads/audio/{$ep_audio}' type='audio/mpeg'>
                        Your browser does not support the audio element.
                    </audio>
                    <div class='episode-icons' style='display: flex; gap: 10px;'>
                        <form method='POST' action=''>
                            <input type='hidden' name='episode_id' value='{$ep_id}'>
                            <button type='submit' name='like' class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                                <i class='bx bxs-heart'></i><span class='like_no'>{$like_count}</span>
                            </button>
                        </form>
                        <button class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                            <i class='bx bxs-message-dots'></i><span class='comment_no'>{$comment_count}</span>
                        </button>";
            if (isset($_SESSION['user_email'])) {
                echo "
            <form action='add_favorite.php' method='POST'>
                <input type='hidden' name='episode_id' value='{$ep_id}'>
                <button class='icon-button' name='bookmark' type='submit' style='background: none; border: none; color: var(--color-warm-coral);'><i class='bx bxs-bookmark'></i></button>
            </form>";
            }
            echo "
                    </div>
                    <!-- Comment Section -->
                <div class='comment-section' id='comment-section-{$ep_id}' style='margin-top: 20px; display: none;'>
                    <h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Leave a Comment</h5>";

            if (isset($_SESSION['user_email'])) {
                echo "
            <form action='submit_comment.php' method='POST' class='comment-form'>
                <input type='hidden' name='episode_id' value='{$ep_id}'>
                <textarea name='comment' rows='3' placeholder='Your Comment' style='width: 100%; padding: 10px; border-radius: var(--border-radius); border: 1px solid var(--color-soft-gray);'></textarea>
                <button type='submit' style='background-color: var(--color-warm-coral); color: var(--color-text-light); padding: 10px 20px; border: none; border-radius: var(--border-radius); margin-top: 10px;'>Post Comment</button>
            </form>";
            } else {
                echo "<p style='color: var(--color-text-dark);'>Please <a href='login.php' style='color: var(--color-warm-coral);'>log in</a> or <a href='signup.php' style='color: var(--color-warm-coral);'>sign up</a> to leave a comment.</p>";
            }

            echo "
                </div>
                <!-- Display Comments -->
                <div class='display-comments' id='display-comments-{$ep_id}' style='margin-top: 20px; overflow: auto; height: 100px; display: none;'>";

            // Fetch comments for the current episode
            $fetch_comments_query = "SELECT * FROM comments WHERE ep_id = '$ep_id' ORDER BY created_at DESC";
            $comments_result = mysqli_query($conn, $fetch_comments_query);

            echo "<h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Comments</h5>";
            if (mysqli_num_rows($comments_result) > 0) {
                while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                    $comment_text = $comment_row['comment'];
                    $user_id = $comment_row['user_id'];

                    // Fetch the username based on user_id
                    $fetch_user_query = "SELECT user_username FROM users WHERE user_id = '$user_id'";
                    $user_result = mysqli_query($conn, $fetch_user_query);
                    $username = mysqli_num_rows($user_result) > 0 ? mysqli_fetch_assoc($user_result)['user_username'] : '';

                    echo "
                <div class='comment' style='background-color: var(--color-cream-white); padding: 10px; border-radius: var(--border-radius); margin-bottom: 10px; max-height: 100px; position: relative;'>
                    <strong style='color: var(--color-dark-plum);'>" . htmlspecialchars($username) . ":</strong>
                    <p style='color: var(--color-text-dark);'>" . htmlspecialchars($comment_text) . "</p>
                </div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }

            echo "
                </div>
                </div>
            </div>";
        }

        echo "
                </div>
            </section>";
    } else {
        // If no results were found
        echo '<section class="episodes-section">
                <h3>No episodes found for "' . htmlspecialchars($search_query) . '"</h3>
              </section>';
    }
}

function display_latest_episodes()
{
    global $conn; // Declare $conn as global to access the database connection

    // Query to fetch the latest episodes ordered by created_at or ep_id (change as per your database structure)
    $sql = "SELECT * FROM episodes ORDER BY published_at DESC";
    $result_query = mysqli_query($conn, $sql);

    // Check if any episodes were found
    if (mysqli_num_rows($result_query) > 0) {
        echo '<section class="episodes-section">
                <h3>Latest Episodes</h3>
                <div class="episodes-grid">';

        while ($row = mysqli_fetch_assoc($result_query)) {
            $ep_id = $row['ep_id'];
            $ep_title = $row['ep_title'];
            $ep_desc = $row['ep_desc'];
            $ep_audio = $row['ep_audio'];
            $ep_thumbnail = $row['ep_thumbnail'];

            // Fetch like count
            $like_query = "SELECT like_count FROM likes WHERE ep_id = '$ep_id'";
            $like_result = mysqli_query($conn, $like_query);
            $like_count = mysqli_num_rows($like_result) > 0 ? mysqli_fetch_assoc($like_result)['like_count'] : 0;

            // Fetch comment count
            $comment_query = "SELECT COUNT(*) as comment_count FROM comments WHERE ep_id = '$ep_id'";
            $comment_result = mysqli_query($conn, $comment_query);
            $comment_count = mysqli_num_rows($comment_result) > 0 ? mysqli_fetch_assoc($comment_result)['comment_count'] : 0;

            echo "
            <!-- Episode Card -->
            <div class='episode-card'>
                <div class='episode-thumbnail' style='border-radius: var(--border-radius);'>
                    <img src='admin/uploads/thumbnails/{$ep_thumbnail}' alt='{$ep_title}' style='border-radius: var(--border-radius);'>
                </div>
                <div class='episode-info' style='padding: 20px;'>
                    <h4 style='color: var(--color-warm-coral); font-family: var(--font-header);'>{$ep_title}</h4>
                    <p style='color: var(--color-text-dark); font-family: var(--font-body);'>{$ep_desc}</p>
                    <audio controls style='width: 100%; margin-bottom: 10px;'>
                        <source src='admin/uploads/audio/{$ep_audio}' type='audio/mpeg'>
                        Your browser does not support the audio element.
                    </audio>
                    <div class='episode-icons' style='display: flex; gap: 10px;'>
                        <form method='POST' action=''>
                            <input type='hidden' name='episode_id' value='{$ep_id}'>
                            <button type='submit' name='like' class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                                <i class='bx bxs-heart'></i><span class='like_no'>{$like_count}</span>
                            </button>
                        </form>
                        <button class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                            <i class='bx bxs-message-dots'></i><span class='comment_no'>{$comment_count}</span>
                        </button>";
            if (isset($_SESSION['user_email'])) {
                echo "
                            <form action='add_favorite.php' method='POST'>
                                <input type='hidden' name='episode_id' value='{$ep_id}'>
                                <button class='icon-button' name='bookmark' type='submit' style='background: none; border: none; color: var(--color-warm-coral);'><i class='bx bxs-bookmark'></i></button>
                            </form>";
            }
            echo "
                    </div>
                    <!-- Comment Section -->
                    <div class='comment-section' id='comment-section-{$ep_id}' style='margin-top: 20px; display: none;'>
                        <h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Leave a Comment</h5>";

            if (isset($_SESSION['user_email'])) {
                echo "
                    <form action='submit_comment.php' method='POST' class='comment-form'>
                        <input type='hidden' name='episode_id' value='{$ep_id}'>
                        <textarea name='comment' rows='3' placeholder='Your Comment' style='width: 100%; padding: 10px; border-radius: var(--border-radius); border: 1px solid var(--color-soft-gray);'></textarea>
                        <button type='submit' style='background-color: var(--color-warm-coral); color: var(--color-text-light); padding: 10px 20px; border: none; border-radius: var(--border-radius); margin-top: 10px;'>Post Comment</button>
                    </form>";
            } else {
                echo "<p style='color: var(--color-text-dark);'>Please <a href='login.php' style='color: var(--color-warm-coral);'>log in</a> or <a href='signup.php' style='color: var(--color-warm-coral);'>sign up</a> to leave a comment.</p>";
            }

            echo "
                    </div>
                    <!-- Display Comments -->
                    <div class='display-comments' id='display-comments-{$ep_id}' style='margin-top: 20px; overflow: auto; height: 100px; display: none;'>";

            // Fetch comments for the current episode
            $fetch_comments_query = "SELECT * FROM comments WHERE ep_id = '$ep_id' ORDER BY created_at DESC";
            $comments_result = mysqli_query($conn, $fetch_comments_query);

            echo "<h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Comments</h5>";
            if (mysqli_num_rows($comments_result) > 0) {
                while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                    $comment_text = $comment_row['comment'];
                    $user_id = $comment_row['user_id'];

                    // Fetch the username based on user_id
                    $fetch_user_query = "SELECT user_username FROM users WHERE user_id = '$user_id'";
                    $user_result = mysqli_query($conn, $fetch_user_query);
                    $username = mysqli_num_rows($user_result) > 0 ? mysqli_fetch_assoc($user_result)['user_username'] : '';

                    echo "
                        <div class='comment' style='background-color: var(--color-cream-white); padding: 10px; border-radius: var(--border-radius); margin-bottom: 10px; max-height: 100px; position: relative;'>
                            <strong style='color: var(--color-dark-plum);'>" . htmlspecialchars($username) . ":</strong>
                            <p style='color: var(--color-text-dark);'>" . htmlspecialchars($comment_text) . "</p>
                        </div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }

            echo "
                    </div>
                </div>
            </div>";
        }

        echo "
                </div>
            </section>";
    } else {
        // If no episodes were found
        echo '<section class="episodes-section">
                <h3>No episodes available</h3>
              </section>';
    }
}

function display_popular_episodes()
{
    global $conn; // Declare $conn as global to access the database connection

    // Query to fetch the most popular episodes based on like_count, ordered by likes
    $sql = "SELECT e.*, COALESCE(SUM(l.like_count), 0) as total_likes 
            FROM episodes e
            LEFT JOIN likes l ON e.ep_id = l.ep_id
            GROUP BY e.ep_id
            ORDER BY total_likes DESC
            LIMIT 5"; // You can change the LIMIT to show more/less episodes

    $result_query = mysqli_query($conn, $sql);

    // Check if any episodes were found
    if (mysqli_num_rows($result_query) > 0) {
        echo '<section class="episodes-section">
                <h3>Popular Episodes</h3>
                <div class="episodes-grid">';

        while ($row = mysqli_fetch_assoc($result_query)) {
            $ep_id = $row['ep_id'];
            $ep_title = $row['ep_title'];
            $ep_desc = $row['ep_desc'];
            $ep_audio = $row['ep_audio'];
            $ep_thumbnail = $row['ep_thumbnail'];
            $total_likes = $row['total_likes'];

            // Fetch comment count
            $comment_query = "SELECT COUNT(*) as comment_count FROM comments WHERE ep_id = '$ep_id'";
            $comment_result = mysqli_query($conn, $comment_query);
            $comment_count = mysqli_num_rows($comment_result) > 0 ? mysqli_fetch_assoc($comment_result)['comment_count'] : 0;

            echo "
            <!-- Episode Card -->
            <div class='episode-card'>
                <div class='episode-thumbnail' style='border-radius: var(--border-radius);'>
                    <img src='admin/uploads/thumbnails/{$ep_thumbnail}' alt='{$ep_title}' style='border-radius: var(--border-radius);'>
                </div>
                <div class='episode-info' style='padding: 20px;'>
                    <h4 style='color: var(--color-warm-coral); font-family: var(--font-header);'>{$ep_title}</h4>
                    <p style='color: var(--color-text-dark); font-family: var(--font-body);'>{$ep_desc}</p>
                    <audio controls style='width: 100%; margin-bottom: 10px;'>
                        <source src='admin/uploads/audio/{$ep_audio}' type='audio/mpeg'>
                        Your browser does not support the audio element.
                    </audio>
                    <div class='episode-icons' style='display: flex; gap: 10px;'>
                        <form method='POST' action=''>
                            <input type='hidden' name='episode_id' value='{$ep_id}'>
                            <button type='submit' name='like' class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                                <i class='bx bxs-heart'></i><span class='like_no'>{$total_likes}</span>
                            </button>
                        </form>
                        <button class='icon-button' style='background: none; border: none; color: var(--color-warm-coral);'>
                            <i class='bx bxs-message-dots'></i><span class='comment_no'>{$comment_count}</span>
                        </button>";
            if (isset($_SESSION['user_email'])) {
                echo "
                            <form action='add_favorite.php' method='POST'>
                                <input type='hidden' name='episode_id' value='{$ep_id}'>
                                <button class='icon-button' name='bookmark' type='submit' style='background: none; border: none; color: var(--color-warm-coral);'><i class='bx bxs-bookmark'></i></button>
                            </form>";
            }
            echo "
                    </div>
                    <!-- Comment Section -->
                    <div class='comment-section' id='comment-section-{$ep_id}' style='margin-top: 20px; display: none;'>
                        <h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Leave a Comment</h5>";

            if (isset($_SESSION['user_email'])) {
                echo "
                    <form action='submit_comment.php' method='POST' class='comment-form'>
                        <input type='hidden' name='episode_id' value='{$ep_id}'>
                        <textarea name='comment' rows='3' placeholder='Your Comment' style='width: 100%; padding: 10px; border-radius: var(--border-radius); border: 1px solid var(--color-soft-gray);'></textarea>
                        <button type='submit' style='background-color: var(--color-warm-coral); color: var(--color-text-light); padding: 10px 20px; border: none; border-radius: var(--border-radius); margin-top: 10px;'>Post Comment</button>
                    </form>";
            } else {
                echo "<p style='color: var(--color-text-dark);'>Please <a href='login.php' style='color: var(--color-warm-coral);'>log in</a> or <a href='signup.php' style='color: var(--color-warm-coral);'>sign up</a> to leave a comment.</p>";
            }

            echo "
                    </div>
                    <!-- Display Comments -->
                    <div class='display-comments' id='display-comments-{$ep_id}' style='margin-top: 20px; overflow: auto; height: 100px; display: none;'>";

            // Fetch comments for the current episode
            $fetch_comments_query = "SELECT * FROM comments WHERE ep_id = '$ep_id' ORDER BY created_at DESC";
            $comments_result = mysqli_query($conn, $fetch_comments_query);

            echo "<h5 style='color: var(--color-blush-pink); font-family: var(--font-header);'>Comments</h5>";
            if (mysqli_num_rows($comments_result) > 0) {
                while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                    $comment_text = $comment_row['comment'];
                    $user_id = $comment_row['user_id'];

                    // Fetch the username based on user_id
                    $fetch_user_query = "SELECT user_username FROM users WHERE user_id = '$user_id'";
                    $user_result = mysqli_query($conn, $fetch_user_query);
                    $username = mysqli_num_rows($user_result) > 0 ? mysqli_fetch_assoc($user_result)['user_username'] : '';

                    echo "
                        <div class='comment' style='background-color: var(--color-cream-white); padding: 10px; border-radius: var(--border-radius); margin-bottom: 10px; max-height: 100px; position: relative;'>
                            <strong style='color: var(--color-dark-plum);'>" . htmlspecialchars($username) . ":</strong>
                            <p style='color: var(--color-text-dark);'>" . htmlspecialchars($comment_text) . "</p>
                        </div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }

            echo "
                    </div>
                </div>
            </div>";
        }

        echo "
                </div>
            </section>";
    } else {
        // If no episodes were found
        echo '<section class="episodes-section">
                <h3>No popular episodes available</h3>
              </section>';
    }
}

function display_favorite_episodes()
{
    global $conn;

    // Ensure the session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in by email and retrieve user_id
    if (isset($_SESSION['user_email'])) {
        $user_email = $_SESSION['user_email'];

        // Get user ID using the email
        $user_query = "SELECT user_id FROM users WHERE user_email = '$user_email'";
        $user_result = mysqli_query($conn, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_row = mysqli_fetch_assoc($user_result);
            $user_id = $user_row['user_id'];

            // Query favorites using user_id
            $sql = "SELECT * FROM favorites WHERE user_id = $user_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<section class="episodes-section">
                        <h3>Your Favorites</h3>
                        <div class="episodes-grid">';

                while ($row = mysqli_fetch_assoc($result)) {
                    $ep_id = $row['ep_id'];
                    $ep_title = $row['fav_title'];
                    $ep_desc = $row['fav_desc'];
                    $ep_audio = $row['fav_audio'];
                    $ep_thumbnail = $row['fav_thumbnail'];

                    echo "
<div class='episode-card'>
    <div class='episode-thumbnail' style='border-radius: var(--border-radius);'>
        <img src='admin/uploads/thumbnails/{$ep_thumbnail}' alt='{$ep_title}' style='border-radius: var(--border-radius);'>
    </div>
    <div class='episode-info' style='padding: 20px;'>
        <h4 style='color: var(--color-warm-coral); font-family: var(--font-header);'>{$ep_title}</h4>
        <p style='color: var(--color-text-dark); font-family: var(--font-body);'>{$ep_desc}</p>
        <audio controls style='width: 100%; margin-bottom: 10px;'>
            <source src='admin/uploads/audio/{$ep_audio}' type='audio/mpeg'>
            Your browser does not support the audio element.
        </audio>
    </div>
</div>";
                }
                echo '</div></section>';
            } else {
                echo '<p>You have no favorite episodes yet.</p>';
            }
        } else {
            echo '<p>User not found. Please log in.</p>';
        }
    } else {
        echo '<p>Please log in to view your favorite episodes.</p>';
    }
}
