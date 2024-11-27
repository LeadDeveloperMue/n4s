<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;

    if ($_SESSION['role'] !== 'admin') {
        header('Location: index.php'); // Redirect non-admin users to the home page
        exit;
    }
    
}
?>


