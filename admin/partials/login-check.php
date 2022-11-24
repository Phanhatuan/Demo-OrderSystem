<?php
    // Authorization - Access control
    //  Check whether the user is logged in or not

    if(!isset($_SESSION['user'])) // If user session is not set
    {
        // User is no logged in
        // Redirect to login page with message

        $_SESSION['bo-login-message'] = "Please login to access admin pannel";
        // Redirect to login page
        header("location:".SITEURL.'admin/login.php');

    }
?>