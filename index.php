<?php
include 'includes/config.php';

// Fetch the latest 4 episodes
$query = "SELECT ep_title, ep_desc, ep_thumbnail FROM episodes ORDER BY rand() LIMIT 0,4";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Girls Podcast</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <!-- Navigation Bar -->
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="#">My Girls Talk</a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php" class="nav-item active">Home</a></li>
        <li><a href="episodes.php" class="nav-item">Episodes</a></li>
        <li><a href="about.php" class="nav-item">About</a></li>
        <li><a href="contact.php" class="nav-item">Contact</a></li>
        <li><a href="faq.php" class="nav-item">FAQs</a></li>
        <li><a href="login.php" class="nav-item">Sign in</a></li>
        <li><a href="signup.php" class="nav-item">Join Us</a></li>

      </ul>
      <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1>Welcome to My Girls Podcast</h1>
        <p>
          Explore the latest episodes, inspiring stories, and lively
          discussions. Join us as we celebrate womanhood and empowerment!
        </p>
        <a href="episodes.php" class="cta">Listen Now</a>
      </div>
      <div class="hero-boxes">
        <div class="box">
          <div class="box-icon">
            <img
              src="assets/svgs/mic3.svg"
              class="floating-svg"
              alt="Microphone Icon" />
          </div>
          <h3>Latest Episodes</h3>
          <p>Catch up on our recent discussions and topics.</p>
        </div>
        <div class="box">
          <div class="box-icon">
            <img src="assets/svgs/Like.svg" class="floating-svg" alt="" />
            <!-- Add your new SVG here -->
          </div>
          <h3>Join the Community</h3>
          <p>Connect with fellow listeners and share your thoughts.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Episodes -->
  <section class="episodes">
    <div class="episodes-header">
      <h2>Recent Episodes</h2>
      <a href="episodes.php" class="show-more">More
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="arrow-icon">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
      </a>
    </div>
    <div class="episode-list" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-around;">
      <?php
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="episode-item" style="flex: 1 1 calc(25% - 20px); display: flex; flex-direction: column; justify-content: space-between; min-height: 400px; background-color: var(--color-cream-white); border-radius: var(--border-radius); box-shadow: var(--box-shadow-light); overflow: hidden;">';

          // Episode Image
          echo '  <div class="episode-image" style="width: 100%; height: 200px; background-color: var(--color-blush-pink);">';
          echo '    <img src="admin/uploads/thumbnails/' . $row['ep_thumbnail'] . '" alt="Episode Image" style="width: 100%; height: 100%; object-fit: cover;" />';
          echo '  </div>';

          // Episode Content
          echo '  <div class="episode-content" style="padding: 15px; display: flex; flex-direction: column; justify-content: flex-start; flex-grow: 1;">';
          echo '    <h3 style="font-family: var(--font-header); font-size: 1.5em; color: var(--color-warm-coral); margin-bottom: 10px;">' . $row['ep_title'] . '</h3>';
          echo '    <p class="description" style="font-family: var(--font-body); color: var(--color-text-dark); flex-grow: 1;">' . $row['ep_desc'] . '</p>';
          echo '  </div>';

          echo '</div>';
        }
      } else {
        echo '<p>No episodes found.</p>';
      }
      ?>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials">
    <h2 class="section-title">Voices of Our Listeners</h2>
    <p class="section-tagline">
      Real stories, real impact—discover what our audience has to say.
    </p>
    <div class="testimonial-list">
      <div class="testimonial-item">
        <blockquote>
          <p>
            "This podcast changed the way I think about entrepreneurship!"
          </p>
          <footer>- Listener Name</footer>
        </blockquote>
      </div>
      <!-- Add more testimonials in this structure -->
      <div class="testimonial-item active">
        <blockquote>
          <p>
            "The insights shared in this podcast are truly eye-opening! It's
            like having a mentor in my pocket."
          </p>
          <footer>- Mark Ndungu</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "I love how relatable the topics are! This podcast has motivated
            me to take action in my life."
          </p>
          <footer>- Amina Wanjiru</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "Each episode is packed with valuable information. I can’t wait
            for the next one!"
          </p>
          <footer>- Tania Muhota</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "Absolutely fantastic! The hosts have a great chemistry and make
            learning enjoyable."
          </p>
          <footer>- Kofi Agyemang</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "This podcast has changed the way I view challenges in my career.
            Highly recommend!"
          </p>
          <footer>- Sarah Mwangi</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "Every episode leaves me inspired and ready to tackle my goals!"
          </p>
          <footer>- Lucas Kamau</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "An engaging and insightful listen. I appreciate the diversity of
            topics!"
          </p>
          <footer>- Grace Okumu</footer>
        </blockquote>
      </div>
      <div class="testimonial-item">
        <blockquote>
          <p>
            "I look forward to each new episode. It feels like a conversation
            with friends."
          </p>
          <footer>- Benard Otieno</footer>
        </blockquote>
      </div>
    </div>
  </section>

  <!-- Finally the Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-links">
        <a href="episodes.php">Episodes</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="faq.php">FAQs</a>

      </div>
      <div class="footer-socials">
        <a href="https://twitter.com/" target="_blank">Twitter</a>
        <a href="https://facebook.com/" target="_blank">Facebook</a>
        <a href="https://instagram.com/" target="_blank">Instagram</a>
        <a href="https://linkedin.com/" target="_blank">LinkedIn</a>
      </div>
      <p class="footer-copy">© 2024 My Girls Podcast. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="assets/js/script.js"></script>
</body>

</html>