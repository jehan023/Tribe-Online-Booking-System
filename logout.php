<?php
    session_start();
    session_unset();
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Login Page
        header("Location: login.php");
    }
?>