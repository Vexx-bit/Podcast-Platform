<?php
session_start();
require_once '../includes/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: sign_in.php");
    exit();
}

// Get the inquiry ID from the URL
if (isset($_GET['cont_id'])) {
    $cont_id = intval($_GET['cont_id']);

    // Update the status to "Replied" in the contacts table
    $sqlUpdateStatus = "UPDATE contacts SET cont_status = 'Replied' WHERE cont_id = $cont_id";

    // Execute the status update query
    if (mysqli_query($conn, $sqlUpdateStatus)) {
        // Query to fetch the inquiry details after updating status
        $sqlInquiry = "SELECT * FROM contacts WHERE cont_id = $cont_id";
        $resultInquiry = mysqli_query($conn, $sqlInquiry);

        if (mysqli_num_rows($resultInquiry) === 1) {
            $inquiryDetails = mysqli_fetch_assoc($resultInquiry);
            $contEmail = $inquiryDetails['cont_email'];
            $contMessage = $inquiryDetails['cont_message'];
            $contName = $inquiryDetails['cont_name'];
            $contStatus = $inquiryDetails['cont_status']; // This will now be "Replied"
        } else {
            die("Inquiry not found.");
        }
    } else {
        die("Error updating status: " . mysqli_error($conn));
    }
} else {
    die("Invalid request.");
}

// Pre-fill the subject and message for the draft email
$subject = "Reply to your inquiry";
$body = "Dear $contName,\n\nThank you for your inquiry.\n\n--- Original Message ---\n$contMessage";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inquiry</title>
    <!-- Boxicons CSS for Icons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Inline CSS with Root Colors -->
    <style>
        :root {
            /* Primary Colors */
            --color-blush-pink: #f4a7b9;
            --color-warm-coral: #ff6f61;
            --color-soft-peach: #ffc5a1;

            /* Accent Colors */
            --color-golden-yellow: #ffd56b;
            --color-lavender: #d5b3e7;

            /* Dark Mode Colors */
            --color-dark-plum: #3b1f2b;
            --color-muted-pink: #c68a9a;
            --color-cream-white: #fff4e1;
            --color-soft-gray: #b0afaf;

            /* Font Families */
            --font-header: 'Poppins', sans-serif;
            --font-body: 'Raleway', sans-serif;

            /* Common Text Colors */
            --color-text-dark: #2d2d2d;
            --color-text-light: #fff4e1;

            /* Shadow */
            --box-shadow-light: 0 4px 6px rgba(0, 0, 0, 0.1);

            /* Border Radius */
            --border-radius: 8px;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-cream-white);
            color: var(--color-text-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 2rem;
            min-height: 100vh;
        }

        .breadcrumb {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-bottom: 1.5rem;
            font-family: var(--font-body);
        }

        .breadcrumb li {
            margin-right: 0.5rem;
        }

        .breadcrumb li+li:before {
            content: "/";
            margin-right: 0.5rem;
            color: var(--color-soft-gray);
        }

        h1 {
            font-family: var(--font-header);
            color: var(--color-warm-coral);
            text-align: center;
            margin-bottom: 1rem;
        }

        h3 {
            font-family: var(--font-header);
            color: var(--color-dark-plum);
        }

        .container {
            background-color: var(--color-soft-peach);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-light);
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        label {
            font-weight: bold;
            color: var(--color-dark-plum);
        }

        .gmail-button {
            background-color: var(--color-warm-coral);
            color: var(--color-text-light);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .gmail-button:hover {
            background-color: var(--color-dark-plum);
        }

        .gmail-button i {
            margin-left: 8px;
            /* Adds spacing between text and icon */
            font-size: 1.2rem;
        }

        @media (min-width: 768px) {
            .container {
                max-width: 800px;
            }
        }

        .footer {
            background-color: var(--color-cream-white);
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid var(--color-muted-pink);
            width: 100%;
            position: absolute;
            bottom: 0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-copy {
            font-family: var(--font-body);
            color: var(--color-text-dark);
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Breadcrumb Navigation -->
    <ul class="breadcrumb">
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="inquiries.php">Inquiries</a></li>
        <li>View Inquiry</li>
    </ul>

    <div class="container">
        <h1>View Inquiry</h1>
        <h3><?php echo $inquiryDetails['cont_name']; ?></h3>
        <p><strong>Email:</strong> <?php echo $inquiryDetails['cont_email']; ?></p>
        <p><strong>Message:</strong> <?php echo nl2br($inquiryDetails['cont_message']); ?></p>

        <h4>Reply to Inquiry</h4>
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($contEmail); ?>&su=<?php echo rawurlencode($subject); ?>&body=<?php echo rawurlencode($body); ?>"
            class="gmail-button" target="_blank">
            Send Reply via Gmail<i class='bx bxl-gmail'></i>
        </a>
    </div>

    <!-- Finally the Footer -->
    <footer class="footer">
        <div class="footer-container">
            <p class="footer-copy">© 2024 My Girls Podcast. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>