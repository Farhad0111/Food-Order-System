<?php
    include('../config/constants.php');
    //1.Destroy the sesssion
    session_destroy(); //Unsets $_SESSION['user']
    header('location:'.SITEURL.'admin/login.php');
