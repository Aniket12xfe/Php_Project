<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    try {
        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();
    } catch (Exception $e) {
        // Handle any errors that occur during session destruction
        echo "Error signing out: " . $e->getMessage();
    }

    // Redirect to the login page
    header("Location: login.php");
    exit;
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
?>