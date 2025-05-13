<?php
session_start();
require_once '../includes/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: sign_in.php");
    exit();
}

// Check if the delete_inquiry parameter is set in the URL
if (isset($_GET['delete_inquiry'])) {
    $inquiryId = $_GET['delete_inquiry'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM contacts WHERE cont_id = '$inquiryId'";

    // Execute the query
    if (mysqli_query($conn, $deleteQuery)) {
        // If successfully deleted, redirect to inquiries page with a success message
        echo "<script>
            alert('Inquiry successfully deleted.');
            window.location.href = 'inquiries.php';
        </script>";
    } else {
        // If deletion fails, show an error message
        echo "<script>
            alert('Failed to delete the inquiry. Please try again.');
            window.location.href = 'inquiries.php';
        </script>";
    }
} else {
    // If no inquiry ID is set in the URL, redirect back to the inquiries page
    header("Location: inquiries.php");
    exit();
}
