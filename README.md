<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
</head>
<body>

  <h1>🎙️ Podcast Platform</h1>
  <p><strong>Podcast Platform</strong> is a web-based application designed for streaming, managing, and interacting with podcast episodes. Built using PHP and MySQL, it allows users to browse episodes, add favorites, and engage with content creators.</p>

  <h2>🎯 Features</h2>
  <ul>
    <li>User registration and login</li>
    <li>Browse and search podcast episodes</li>
    <li>Add episodes to favorites</li>
    <li>Admin panel for managing episodes and user interactions</li>
    <li>Responsive design for various devices</li>
  </ul>

  <h2>📁 Project Structure</h2>
  <pre>
Podcast-Platform/
├── admin/               --> Admin panel files
├── assets/              --> Images and other assets
├── functions/           --> Helper functions
├── includes/            --> Common PHP includes
├── index.php            --> Homepage
├── login.php            --> User login page
├── logout.php           --> User logout script
├── signup.php           --> User registration page
├── episodes.php         --> Episodes listing page
├── favorite_episodes.php--> User's favorite episodes page
├── search_episode.php   --> Episode search functionality
├── about.php            --> About page
├── contact.php          --> Contact page
├── faq.php              --> Frequently Asked Questions page
└── LICENSE              --> License file
  </pre>

  <h2>⚙️ Installation</h2>
  <ol>
    <li>Clone the repository:
      <pre><code>git clone https://github.com/Vexx-bit/Podcast-Platform.git</code></pre>
    </li>
    <li>Set up a MySQL database and import the provided SQL file:
      <ul>
        <li>Create a new database (e.g., <code>podcast_platform</code>)</li>
        <li>Import the SQL script located in the <code>database/</code> directory</li>
      </ul>
    </li>
    <li>Configure the database connection:
      <ul>
        <li>Open the relevant configuration file in the <code>includes/</code> directory</li>
        <li>Update the database credentials accordingly</li>
      </ul>
    </li>
    <li>Run the application:
      <ul>
        <li>Place the project folder in your web server's root directory (e.g., <code>htdocs</code> for XAMPP)</li>
        <li>Start your web server and navigate to <code>http://localhost/Podcast-Platform/</code></li>
      </ul>
    </li>
  </ol>

  <h2>🔐 Administrator Access</h2>
  <ul>
    <li>Access the admin panel via <code>admin/</code></li>
    <li>Login using the administrator credentials set in the database</li>
  </ul>

  <h2>📄 License</h2>
  <p>This project is licensed under the terms of the <a href="https://github.com/Vexx-bit/Podcast-Platform/blob/main/LICENSE">MIT License</a>.</p>

  <p>Developed with ❤️ by Samuel Kang'ethe (<a href="https://github.com/Vexx-bit">Vexx-bit</a>)</p>

</body>
</html>
