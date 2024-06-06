<?php 


    // Authorization - Access Control
    if(!isset($_SESSION['user'])) // If user session is not set
    {
        // User is not logged in
        $_SESSION['no-login-message'] = "<div class='error'>Please login to access the admin panel</div>";
        header('location:'.SITEURL.'admin/login.php');
    }

