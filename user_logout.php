<?php
    // Start or resume session
    session_start();

    // Clear all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Clear the user_id cookie
    setcookie('user_id', '', time() - 1, '/');

    // Redirect to the login page or another appropriate page
    header('location: login.php');
    exit; // Ensure that no further code is executed after the redirection
?>
